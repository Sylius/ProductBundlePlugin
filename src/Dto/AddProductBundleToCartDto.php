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

namespace Sylius\ProductBundlePlugin\Dto;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\ProductBundlePlugin\Command\ProductCodeAwareInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;

final class AddProductBundleToCartDto implements AddProductBundleToCartDtoInterface, ProductCodeAwareInterface
{
    private ArrayCollection $productBundleItems;

    public function __construct(
        private OrderInterface $cart,
        private OrderItemInterface $cartItem,
        private ProductInterface $product,
        array $productBundleItems,
    ) {
        $this->productBundleItems = new ArrayCollection($productBundleItems);
    }

    public function getCart(): OrderInterface
    {
        return $this->cart;
    }

    public function setCart(OrderInterface $cart): void
    {
        $this->cart = $cart;
    }

    public function getCartItem(): OrderItemInterface
    {
        return $this->cartItem;
    }

    public function setCartItem(OrderItemInterface $cartItem): void
    {
        $this->cartItem = $cartItem;
    }

    public function getProduct(): ProductInterface
    {
        return $this->product;
    }

    public function setProduct(ProductInterface $product): void
    {
        $this->product = $product;
    }

    public function getProductBundleItems(): ArrayCollection
    {
        return $this->productBundleItems;
    }

    public function getProductCode(): string
    {
        return $this->product->getCode() ?? '';
    }
}
