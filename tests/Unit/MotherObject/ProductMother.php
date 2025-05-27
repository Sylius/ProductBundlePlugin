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

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Tests\Sylius\ProductBundlePlugin\Entity\Product;

final class ProductMother
{
    public static function create(): ProductInterface
    {
        return new Product();
    }

    public static function createWithBundle(ProductBundleInterface $productBundle): ProductInterface
    {
        $product = self::create();

        $product->setProductBundle($productBundle);

        return $product;
    }

    public static function createWithProductVariantAndCode(
        ProductVariantInterface $productVariant,
        string $code,
    ): ProductInterface {
        $product = self::create();

        $product->addVariant($productVariant);
        $product->setCode($code);

        return $product;
    }

    public static function createWithChannelAndProductVariantAndCode(
        ChannelInterface $channel,
        ProductVariantInterface $productVariant,
        string $code,
    ): ProductInterface {
        $product = self::createWithProductVariantAndCode($productVariant, $code);

        $product->addChannel($channel);

        return $product;
    }

    public static function createWithCode(string $code): ProductInterface
    {
        $product = self::create();

        $product->setCode($code);

        return $product;
    }

    public static function createDisabledWithCode(string $code): ProductInterface
    {
        $product = self::createWithCode($code);

        $product->disable();

        return $product;
    }
}
