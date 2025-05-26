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

use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\Component\Product\Factory\ProductFactoryInterface as DecoratedProductFactoryInterface;
use Sylius\Component\Product\Model\ProductInterface as BaseProductInterface;
use Sylius\Component\Resource\Factory\FactoryInterface;

final class ProductFactory implements ProductFactoryInterface
{
    public function __construct(
        private DecoratedProductFactoryInterface $decoratedFactory,
        private FactoryInterface $productBundleFactory,
    ) {
    }

    public function createWithVariantAndBundle(): BaseProductInterface
    {
        /** @var ProductBundleInterface $productBundle */
        $productBundle = $this->productBundleFactory->createNew();

        /** @var ProductInterface $product */
        $product = $this->createWithVariant();

        $productBundle->setProduct($product);

        $product->setProductBundle($productBundle);

        return $product;
    }

    public function createNew(): BaseProductInterface
    {
        /** @var BaseProductInterface $product */
        $product = $this->decoratedFactory->createNew();

        return $product;
    }

    public function createWithVariant(): BaseProductInterface
    {
        return $this->decoratedFactory->createWithVariant();
    }
}
