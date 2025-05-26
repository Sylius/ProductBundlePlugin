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

namespace BitBag\SyliusProductBundlePlugin\Factory;

use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleItemInterface;
use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleOrderItemInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ProductBundleOrderItemFactory implements ProductBundleOrderItemFactoryInterface
{
    public function __construct(
        private FactoryInterface $decoratedFactory,
    ) {
    }

    public function createNew(): ProductBundleOrderItemInterface
    {
        /** @var ProductBundleOrderItemInterface $productBundleOrderItem */
        $productBundleOrderItem = $this->decoratedFactory->createNew();

        return $productBundleOrderItem;
    }

    public function createFromProductBundleItem(ProductBundleItemInterface $bundleItem): ProductBundleOrderItemInterface
    {
        /** @var ProductBundleOrderItemInterface $productBundleOrderItem */
        $productBundleOrderItem = $this->decoratedFactory->createNew();

        $productBundleOrderItem->setProductBundleItem($bundleItem);
        $productBundleOrderItem->setProductVariant($bundleItem->getProductVariant());
        $productBundleOrderItem->setQuantity($bundleItem->getQuantity());

        return $productBundleOrderItem;
    }
}
