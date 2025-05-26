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

namespace Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler;

use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\Component\Order\Model\OrderInterface;

interface CartProcessorInterface
{
    public function process(
        OrderInterface $cart,
        ProductBundleInterface $productBundle,
        int $quantity,
    ): void;
}
