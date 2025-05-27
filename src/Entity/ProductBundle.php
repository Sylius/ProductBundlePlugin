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

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class ProductBundle implements ProductBundleInterface
{
    use TimestampableTrait;

    protected mixed $id = null;

    protected ?ProductInterface $product;

    /** @var ProductBundleItemInterface[]|Collection */
    protected Collection $productBundleItems;

    protected bool $isPackedProduct = false;

    public function __construct()
    {
        $this->createdAt = new \DateTime();
        $this->productBundleItems = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getProduct(): ?ProductInterface
    {
        return $this->product;
    }

    public function setProduct(?ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getProductBundleItems(): Collection
    {
        return $this->productBundleItems;
    }

    public function addProductBundleItem(ProductBundleItemInterface $productBundleItem): void
    {
        if (!$this->hasProductBundleItem($productBundleItem)) {
            $productBundleItem->setProductBundle($this);

            $this->productBundleItems->add($productBundleItem);
        }
    }

    public function removeProductBundleItem(ProductBundleItemInterface $productBundleItem): void
    {
        if ($this->hasProductBundleItem($productBundleItem)) {
            $productBundleItem->setProductBundle(null);

            $this->productBundleItems->removeElement($productBundleItem);
        }
    }

    public function hasProductBundleItem(ProductBundleItemInterface $productBundleItem): bool
    {
        return $this->productBundleItems->contains($productBundleItem);
    }

    public function isPackedProduct(): bool
    {
        return $this->isPackedProduct;
    }

    public function setIsPackedProduct(bool $isPackedProduct): void
    {
        $this->isPackedProduct = $isPackedProduct;
    }
}
