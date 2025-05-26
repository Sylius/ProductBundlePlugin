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

namespace Tests\Sylius\ProductBundlePlugin\Unit\Factory;

use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDtoInterface;
use Sylius\ProductBundlePlugin\Factory\AddProductBundleItemToCartCommandFactoryInterface;
use Sylius\ProductBundlePlugin\Factory\AddProductBundleToCartDtoFactory;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\AddProductBundleItemToCartCommandMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\OrderItemMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\OrderMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductBundleItemMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductBundleMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductMother;

final class AddProductBundleToCartDtoFactoryTest extends TestCase
{
    /** @var AddProductBundleItemToCartCommandFactoryInterface|mixed|MockObject */
    private $addProductBundleItemToCartCommandFactory;

    protected function setUp(): void
    {
        $this->addProductBundleItemToCartCommandFactory = $this->createMock(
            AddProductBundleItemToCartCommandFactoryInterface::class,
        );
    }

    public function testCreateAddProductBundleToCartDtoObject(): void
    {
        $bundleItem1 = ProductBundleItemMother::create();
        $bundleItem2 = ProductBundleItemMother::create();
        $addProductBundleItemToCartCommand1 = AddProductBundleItemToCartCommandMother::create($bundleItem1);
        $addProductBundleItemToCartCommand2 = AddProductBundleItemToCartCommandMother::create($bundleItem2);

        $this->addProductBundleItemToCartCommandFactory->expects(self::exactly(2))
            ->method('createNew')
            ->withConsecutive([$bundleItem1], [$bundleItem2])
            ->willReturnOnConsecutiveCalls($addProductBundleItemToCartCommand1, $addProductBundleItemToCartCommand2)
        ;

        $factory = new AddProductBundleToCartDtoFactory($this->addProductBundleItemToCartCommandFactory);

        $order = OrderMother::create();
        $orderItem = OrderItemMother::create();
        $productBundle = ProductBundleMother::createWithBundleItems($bundleItem1, $bundleItem2);
        $product = ProductMother::createWithBundle($productBundle);
        $dto = $factory->createNew($order, $orderItem, $product);

        self::assertInstanceOf(AddProductBundleToCartDtoInterface::class, $dto);
        self::assertSame($order, $dto->getCart());
        self::assertSame($orderItem, $dto->getCartItem());
        self::assertSame($product, $dto->getProduct());
        self::assertCount(2, $dto->getProductBundleItems());
    }
}
