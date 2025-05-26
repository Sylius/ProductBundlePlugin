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

namespace Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Modifier\OrderItemQuantityModifierInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Factory\OrderItemFactoryInterface;
use Sylius\ProductBundlePlugin\Factory\ProductBundleOrderItemFactoryInterface;
use Webmozart\Assert\Assert;

final class CartProcessor implements CartProcessorInterface
{
    public function __construct(
        private OrderItemQuantityModifierInterface $orderItemQuantityModifier,
        private ProductBundleOrderItemFactoryInterface $productBundleOrderItemFactory,
        private OrderModifierInterface $orderModifier,
        private OrderItemFactoryInterface $cartItemFactory,
    ) {
    }

    public function process(
        OrderInterface $cart,
        ProductBundleInterface $productBundle,
        int $quantity,
    ): void {
        Assert::greaterThan($quantity, 0);

        $product = $productBundle->getProduct();
        Assert::notNull($product);

        /** @var ProductVariantInterface|false $productVariant */
        $productVariant = $product->getVariants()->first();
        Assert::notFalse($productVariant);

        $cartItem = $this->cartItemFactory->createWithVariant($productVariant);
        $this->orderItemQuantityModifier->modify($cartItem, $quantity);

        foreach ($productBundle->getProductBundleItems() as $bundleItem) {
            $productBundleOrderItem = $this->productBundleOrderItemFactory->createFromProductBundleItem($bundleItem);
            $cartItem->addProductBundleOrderItem($productBundleOrderItem);
        }

        $this->orderModifier->addToOrder($cart, $cartItem);
    }
}
