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

namespace Sylius\ProductBundlePlugin\Factory;

use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;

final readonly class OrderItemFactory implements OrderItemFactoryInterface
{
    public function __construct(
        private CartItemFactoryInterface $decoratedFactory,
    ) {
    }

    public function createNew(): OrderItemInterface
    {
        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->decoratedFactory->createNew();

        return $orderItem;
    }

    public function createWithVariant(ProductVariantInterface $productVariant): OrderItemInterface
    {
        $orderItem = $this->createNew();
        $orderItem->setVariant($productVariant);

        return $orderItem;
    }

    public function createForProduct(ProductInterface $product): \Sylius\Component\Core\Model\OrderItemInterface
    {
        return $this->decoratedFactory->createForProduct($product);
    }

    public function createForCart(OrderInterface $order): \Sylius\Component\Core\Model\OrderItemInterface
    {
        return $this->decoratedFactory->createForCart($order);
    }
}
