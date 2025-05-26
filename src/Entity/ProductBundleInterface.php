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

namespace Sylius\ProductBundlePlugin\Entity;

use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\Component\Resource\Model\TimestampableInterface;

interface ProductBundleInterface extends ResourceInterface, TimestampableInterface
{
    public function getProduct(): ?ProductInterface;

    public function setProduct(?ProductInterface $product): void;

    public function getProductBundleItems(): Collection;

    public function addProductBundleItem(ProductBundleItemInterface $productBundleItem): void;

    public function removeProductBundleItem(ProductBundleItemInterface $productBundleItem): void;

    public function hasProductBundleItem(ProductBundleItemInterface $productBundleItem): bool;

    public function isPackedProduct(): bool;

    public function setIsPackedProduct(bool $isPackedProduct): void;
}
