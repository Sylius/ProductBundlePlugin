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

namespace Sylius\ProductBundlePlugin\Command;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItemInterface;

final class AddProductBundleItemToCartCommand
{
    public function __construct(
        private ProductBundleItemInterface $productBundleItem,
        private ?ProductVariantInterface $productVariant = null,
        private ?int $quantity = null,
    ) {
        $this->productVariant = $productBundleItem->getProductVariant();
        $this->quantity = $productBundleItem->getQuantity();
    }

    public function getProductBundleItem(): ProductBundleItemInterface
    {
        return $this->productBundleItem;
    }

    public function getProductVariant(): ?ProductVariantInterface
    {
        return $this->productVariant;
    }

    public function setProductVariant(ProductVariantInterface $productVariant): void
    {
        $this->productVariant = $productVariant;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }
}
