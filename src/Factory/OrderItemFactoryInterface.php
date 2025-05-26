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

use BitBag\SyliusProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

interface OrderItemFactoryInterface extends FactoryInterface, CartItemFactoryInterface
{
    public function createWithVariant(ProductVariantInterface $productVariant): OrderItemInterface;
}
