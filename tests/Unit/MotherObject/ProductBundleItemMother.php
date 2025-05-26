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

namespace Tests\Sylius\ProductBundlePlugin\Unit\MotherObject;

use Sylius\ProductBundlePlugin\Entity\ProductBundleItem;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItemInterface;

final class ProductBundleItemMother
{
    public static function create(): ProductBundleItemInterface
    {
        return new ProductBundleItem();
    }
}
