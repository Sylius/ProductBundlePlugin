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

namespace Tests\Sylius\ProductBundlePlugin\Unit\Handler\Api;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\ProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;
use Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler\CartProcessorInterface;
use Sylius\ProductBundlePlugin\Handler\Api\AddProductBundleToCartHandler;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\OrderMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductBundleMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductMother;
use Tests\Sylius\ProductBundlePlugin\Unit\TypeExceptionMessage;
use Webmozart\Assert\InvalidArgumentException;

final class AddProductBundleToCartHandlerTest extends TestCase
{
    /** @var mixed|MockObject|OrderRepositoryInterface */
    private $orderRepository;

    /** @var mixed|MockObject|ProductRepositoryInterface */
    private $productRepository;

    /** @var CartProcessorInterface|mixed|MockObject */
    private $cartProcessor;

    protected function setUp(): void
    {
        $this->orderRepository = $this->createMock(OrderRepositoryInterface::class);
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);
        $this->cartProcessor = $this->createMock(CartProcessorInterface::class);
    }

    public function testThrowExceptionIfCartDoesntExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(TypeExceptionMessage::EXPECTED_VALUE_OTHER_THAN_NULL);

        $this->orderRepository
            ->method('findCartByTokenValue')
            ->willReturn(null)
        ;

        $command = new AddProductBundleToCartDto('', '', 1);
        $handler = $this->createHandler();
        $handler($command);
    }

    public function testProcessCart(): void
    {
        $cart = OrderMother::create();
        $this->orderRepository
            ->method('findCartByTokenValue')
            ->willReturn($cart)
        ;

        $productBundle = ProductBundleMother::create();
        $product = ProductMother::createWithBundle($productBundle);
        $this->productRepository
            ->method('findOneByCode')
            ->willReturn($product)
        ;

        $this->cartProcessor->expects(self::once())
            ->method('process')
            ->with($cart, $productBundle, 2)
        ;

        $command = new AddProductBundleToCartDto('', '', 2);
        $handler = $this->createHandler();
        $handler($command);
    }

    private function createHandler(): AddProductBundleToCartHandler
    {
        return new AddProductBundleToCartHandler(
            $this->orderRepository,
            $this->productRepository,
            $this->cartProcessor,
        );
    }
}
