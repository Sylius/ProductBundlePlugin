<?php

/*
 * This file is part of the Sylius ProductBundle Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace Tests\Sylius\ProductBundlePlugin\Unit\Validator;

use PHPUnit\Framework\MockObject\MockObject;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Inventory\Checker\AvailabilityCheckerInterface;
use Sylius\ProductBundlePlugin\Command\AddProductBundleToCartCommand;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Validator\HasAvailableProductBundle;
use Sylius\ProductBundlePlugin\Validator\HasAvailableProductBundleValidator;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ChannelMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\OrderMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductVariantMother;

final class HasAvailableProductBundleValidatorTest extends ConstraintValidatorTestCase
{
    private const ORDER_ID = 5;

    private const PRODUCT_CODE = 'MY_PROD';

    private const CHANNEL_NAME = 'My Awesome Channel';

    /** @var mixed|MockObject|ProductRepositoryInterface */
    private $productRepository;

    /** @var mixed|MockObject|OrderRepositoryInterface */
    private $orderRepository;

    /** @var mixed|MockObject|AvailabilityCheckerInterface */
    private $availabilityChecker;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->availabilityChecker = $this->createMock(AvailabilityCheckerInterface::class);

        parent::setUp();
    }

    /**
     * @dataProvider pessimisticDataProvider
     */
    public function testPessimisticCase(
        ProductInterface $product,
        ?OrderInterface $cart,
        bool $isStockSufficient,
        string $violationMessage,
        array $violationParameters,
    ): void {
        $this->productRepository->method('findOneByCode')
            ->with(self::PRODUCT_CODE)
            ->willReturn($product)
        ;

        $this->orderRepository->method('findCartById')
            ->with(self::ORDER_ID)
            ->willReturn($cart)
        ;

        $productVariant = $product->getVariants()->first();
        $this->availabilityChecker->method('isStockSufficient')
            ->with($productVariant, 1)
            ->willReturn($isStockSufficient)
        ;

        $command = new AddProductBundleToCartCommand(self::ORDER_ID, self::PRODUCT_CODE);
        $constraint = new HasAvailableProductBundle();

        $this->validator->validate($command, $constraint);

        $this->buildViolation($violationMessage)
            ->setParameters($violationParameters)
            ->assertRaised();
    }

    public static function pessimisticDataProvider(): iterable
    {
        yield 'product is disabled' => self::getProductDisabledCaseData();
        yield 'product variant is disabled' => self::getProductVariantDisabledCaseData();
        yield 'product\'s channel and cart\'s channel are different' => self::getProductAndCartChannelsAreDifferentCaseData();
        yield 'product\'s quantity in the cart exceeds the stock' => self::getProductQuantityExceedsStockCaseData();
    }

    private static function getProductDisabledCaseData(): array
    {
        $product = ProductMother::createDisabledWithCode(self::PRODUCT_CODE);
        $violationMessage = HasAvailableProductBundle::PRODUCT_DISABLED_MESSAGE;
        $violationParameters = [
            '{{ code }}' => self::PRODUCT_CODE,
        ];

        return [$product, null, false, $violationMessage, $violationParameters];
    }

    private static function getProductVariantDisabledCaseData(): array
    {
        $productVariant = ProductVariantMother::createDisabledWithCode(self::PRODUCT_CODE);
        $product = ProductMother::createWithProductVariantAndCode($productVariant, self::PRODUCT_CODE);
        $violationMessage = HasAvailableProductBundle::PRODUCT_VARIANT_DISABLED_MESSAGE;
        $violationParameters = [
            '{{ code }}' => self::PRODUCT_CODE,
        ];

        return [$product, null, false, $violationMessage, $violationParameters];
    }

    private static function getProductAndCartChannelsAreDifferentCaseData(): array
    {
        $productVariant = ProductVariantMother::createWithCode(self::PRODUCT_CODE);
        $product = ProductMother::createWithProductVariantAndCode($productVariant, self::PRODUCT_CODE);

        $channel = ChannelMother::createWithName(self::CHANNEL_NAME);
        $cart = OrderMother::createWithChannel($channel);

        $violationMessage = HasAvailableProductBundle::PRODUCT_DOESNT_EXIST_IN_CHANNEL_MESSAGE;
        $violationParameters = [
            '{{ channel }}' => self::CHANNEL_NAME,
            '{{ code }}' => self::PRODUCT_CODE,
        ];

        return [$product, $cart, false, $violationMessage, $violationParameters];
    }

    private static function getProductQuantityExceedsStockCaseData(): array
    {
        $channel = ChannelMother::createWithName(self::CHANNEL_NAME);
        $productVariant = ProductVariantMother::createWithCode(self::PRODUCT_CODE);
        $product = ProductMother::createWithChannelAndProductVariantAndCode(
            $channel,
            $productVariant,
            self::PRODUCT_CODE,
        );

        $cart = OrderMother::createWithChannel($channel);

        $violationMessage = HasAvailableProductBundle::PRODUCT_VARIANT_INSUFFICIENT_STOCK_MESSAGE;
        $violationParameters = [
            '{{ code }}' => self::PRODUCT_CODE,
        ];

        return [$product, $cart, false, $violationMessage, $violationParameters];
    }

    protected function createValidator(): HasAvailableProductBundleValidator
    {
        return new HasAvailableProductBundleValidator(
            $this->productRepository,
            $this->orderRepository,
            $this->availabilityChecker,
        );
    }
}
