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
use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Sylius\Component\Order\Model\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;

interface AddProductBundleToCartDtoInterface extends AddToCartCommandInterface
{
    public function setCart(OrderInterface $cart): void;

    public function setCartItem(OrderItemInterface $cartItem): void;

    public function getProduct(): ProductInterface;

    public function setProduct(ProductInterface $product): void;

    public function getProductBundleItems(): ArrayCollection;
}
