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

use Sylius\ProductBundlePlugin\Command\AddProductBundleItemToCartCommand;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItemInterface;

interface AddProductBundleItemToCartCommandFactoryInterface
{
    public function createNew(ProductBundleItemInterface $bundleItem): AddProductBundleItemToCartCommand;
}
