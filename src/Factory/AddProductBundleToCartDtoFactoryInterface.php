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

use Sylius\Component\Order\Model\OrderInterface;
use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDtoInterface;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;

interface AddProductBundleToCartDtoFactoryInterface
{
    public function createNew(
        OrderInterface $order,
        OrderItemInterface $orderItem,
        ProductInterface $product,
    ): AddProductBundleToCartDtoInterface;
}
