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

use Sylius\Component\Product\Factory\ProductFactoryInterface as BaseProductFactoryInterface;
use Sylius\Component\Product\Model\ProductInterface;

interface ProductFactoryInterface extends BaseProductFactoryInterface
{
    public function createWithVariantAndBundle(): ProductInterface;
}
