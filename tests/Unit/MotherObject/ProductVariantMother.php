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

namespace Tests\BitBag\SyliusProductBundlePlugin\Unit\MotherObject;

use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Core\Model\ProductVariantInterface;

final class ProductVariantMother
{
    public static function create(): ProductVariantInterface
    {
        return new ProductVariant();
    }

    public static function createWithCode(string $code): ProductVariantInterface
    {
        $productVariant = self::create();

        $productVariant->setCode($code);

        return $productVariant;
    }

    public static function createDisabledWithCode(string $code): ProductVariantInterface
    {
        $productVariant = self::createWithCode($code);

        $productVariant->disable();

        return $productVariant;
    }
}
