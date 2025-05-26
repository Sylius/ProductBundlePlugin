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

namespace BitBag\SyliusProductBundlePlugin\Entity;

use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Model\TimestampableTrait;

class ProductBundleOrderItem implements ProductBundleOrderItemInterface
{
    use TimestampableTrait;

    /** @var int */
    protected $id;

    /** @var OrderItemInterface|null */
    protected $orderItem;

    /** @var ProductBundleItemInterface|null */
    protected $productBundleItem;

    /** @var ProductVariantInterface|null */
    protected $productVariant;

    /** @var int|null */
    protected $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getOrderItem(): ?OrderItemInterface
    {
        return $this->orderItem;
    }

    public function setOrderItem(?OrderItemInterface $orderItem): void
    {
        $this->orderItem = $orderItem;
    }

    public function getProductBundleItem(): ?ProductBundleItemInterface
    {
        return $this->productBundleItem;
    }

    public function setProductBundleItem(?ProductBundleItemInterface $productBundleItem): void
    {
        $this->productBundleItem = $productBundleItem;
    }

    public function getProductVariant(): ?ProductVariantInterface
    {
        return $this->productVariant;
    }

    public function setProductVariant(?ProductVariantInterface $productVariant): void
    {
        $this->productVariant = $productVariant;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(?int $quantity): void
    {
        $this->quantity = $quantity;
    }
}
