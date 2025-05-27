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

use Sylius\ProductBundlePlugin\Entity\ProductBundle;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItemInterface;

final class ProductBundleMother
{
    public static function create(): ProductBundleInterface
    {
        return new ProductBundle();
    }

    /**
     * @param ProductBundleItemInterface ...$bundleItems
     */
    public static function createWithBundleItems(...$bundleItems): ProductBundleInterface
    {
        $productBundle = self::create();

        foreach ($bundleItems as $bundleItem) {
            $productBundle->addProductBundleItem($bundleItem);
        }

        return $productBundle;
    }
}
