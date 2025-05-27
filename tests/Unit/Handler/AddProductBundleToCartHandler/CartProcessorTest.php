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

namespace Tests\Sylius\ProductBundlePlugin\Unit\Handler\AddProductBundleToCartHandler;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Order\Model\Order;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Sylius\Component\Product\Model\ProductVariantInterface;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundle;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItem;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleOrderItem;
use Sylius\ProductBundlePlugin\Entity\ProductBundleOrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Factory\OrderItemFactoryInterface;
use Sylius\ProductBundlePlugin\Factory\ProductBundleOrderItemFactoryInterface;
use Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler\CartProcessor;
use Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler\CartProcessorInterface;
use Tests\Sylius\ProductBundlePlugin\Entity\OrderItem;
use Tests\Sylius\ProductBundlePlugin\Entity\Product;
use Webmozart\Assert\Assert;
use Webmozart\Assert\InvalidArgumentException;

final class CartProcessorTest extends TestCase
{
    /** @var mixed|MockObject|OrderItemQuantityModifierInterface */
    private $orderItemQuantityModifier;

    /** @var ProductBundleOrderItemFactoryInterface|mixed|MockObject */
    private $productBundleOrderItemFactory;

    /** @var mixed|MockObject|OrderModifierInterface */
    private $orderModifier;

    /** @var OrderItemFactoryInterface|mixed|MockObject */
    private $cartItemFactory;

    protected function setUp(): void
    {
        $this->orderItemQuantityModifier = $this->createMock(OrderItemQuantityModifierInterface::class);
        $this->productBundleOrderItemFactory = $this->createMock(ProductBundleOrderItemFactoryInterface::class);
        $this->orderModifier = $this->createMock(OrderModifierInterface::class);
        $this->cartItemFactory = $this->createMock(OrderItemFactoryInterface::class);
    }

    public function testThrowExceptionIfQuantityNotGreaterThanZero(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $cart = $this->createCart();
        $productBundle = $this->createProductBundle();

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 0);
    }

    public function testThrowExceptionIfProductIsNull(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $cart = $this->createCart();
        $productBundle = $this->createProductBundle();

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 1);
    }

    public function testThrowExceptionIfProductHasNoVariant(): void
    {
        $this->expectException(InvalidArgumentException::class);

        $cart = $this->createCart();
        $productBundle = $this->createProductBundleWithProduct();

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 1);
    }

    public function testCreateCartItem(): void
    {
        $cart = $this->createCart();
        $productVariant = new ProductVariant();
        $product = $this->createProductWithVariant($productVariant);
        $productBundle = $this->createProductBundleWithProduct($product);

        $this->cartItemFactory->expects(self::once())
            ->method('createWithVariant')
            ->with($productVariant)
        ;

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 2);
    }

    public function testModifyCartItemQuantity(): void
    {
        $cart = $this->createCart();
        $productVariant = new ProductVariant();
        $product = $this->createProductWithVariant($productVariant);
        $productBundle = $this->createProductBundleWithProduct($product);
        $cartItem = $this->createCartItem();

        $this->cartItemFactory
            ->method('createWithVariant')
            ->willReturn($cartItem)
        ;
        $this->orderItemQuantityModifier->expects(self::once())
            ->method('modify')
            ->with($cartItem, 2)
        ;

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 2);
    }

    public function testCreateBundleOrderItemsFromBundleItems(): void
    {
        $bundleItem1 = $this->createProductBundleItem();
        $bundleItem2 = $this->createProductBundleItem();

        $productBundleOrderItem1 = $this->createProductBundleOrderItem();
        $productBundleOrderItem2 = $this->createProductBundleOrderItem();

        $cart = $this->createCart();
        $product = $this->createProductWithVariant();
        $productBundle = $this->createProductBundleWithProduct($product);
        $productBundle->addProductBundleItem($bundleItem1);
        $productBundle->addProductBundleItem($bundleItem2);

        $cartItem = $this->createMock(OrderItemInterface::class);

        $expectedBundleItems = [[$productBundleOrderItem1], [$productBundleOrderItem2]];
        $callIndex = 0;

        $cartItem->expects(self::exactly(2))
            ->method('addProductBundleOrderItem')
            ->willReturnCallback(function (...$args) use (&$callIndex, $expectedBundleItems) {
                Assert::same($expectedBundleItems[$callIndex], $args);
                ++$callIndex;
            });

        $this->cartItemFactory
            ->method('createWithVariant')
            ->willReturn($cartItem);

        $expectedFactoryArgs = [[$bundleItem1], [$bundleItem2]];
        $returnValues = [$productBundleOrderItem1, $productBundleOrderItem2];
        $factoryCallIndex = 0;

        $this->productBundleOrderItemFactory
            ->expects(self::exactly(2))
            ->method('createFromProductBundleItem')
            ->willReturnCallback(function (...$args) use (&$factoryCallIndex, $expectedFactoryArgs, $returnValues) {
                Assert::same($expectedFactoryArgs[$factoryCallIndex], $args);

                return $returnValues[$factoryCallIndex++];
            });

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 1);
    }

    public function testAddCartItemToOrder(): void
    {
        $cart = $this->createCart();
        $product = $this->createProductWithVariant();
        $productBundle = $this->createProductBundleWithProduct($product);
        $cartItem = $this->createCartItem();

        $this->cartItemFactory
            ->method('createWithVariant')
            ->willReturn($cartItem)
        ;
        $this->orderModifier->expects(self::once())
            ->method('addToOrder')
            ->with($cart, $cartItem)
        ;

        $processor = $this->createProcessor();
        $processor->process($cart, $productBundle, 1);
    }

    private function createProcessor(): CartProcessorInterface
    {
        return new CartProcessor(
            $this->orderItemQuantityModifier,
            $this->productBundleOrderItemFactory,
            $this->orderModifier,
            $this->cartItemFactory,
        );
    }

    private function createCart(): OrderInterface
    {
        return new Order();
    }

    private function createCartItem(): OrderItemInterface
    {
        return new OrderItem();
    }

    private function createProductWithVariant(?ProductVariantInterface $productVariant = null): ProductInterface
    {
        if (null === $productVariant) {
            $productVariant = new ProductVariant();
        }

        $product = new Product();
        $product->addVariant($productVariant);

        return $product;
    }

    private function createProductBundle(): ProductBundleInterface
    {
        return new ProductBundle();
    }

    private function createProductBundleWithProduct(?ProductInterface $product = null): ProductBundleInterface
    {
        if (null === $product) {
            $product = new Product();
        }

        $productBundle = $this->createProductBundle();
        $productBundle->setProduct($product);

        return $productBundle;
    }

    private function createProductBundleItem(): ProductBundleItemInterface
    {
        return new ProductBundleItem();
    }

    private function createProductBundleOrderItem(): ProductBundleOrderItemInterface
    {
        return new ProductBundleOrderItem();
    }
}
