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

namespace BitBag\SyliusProductBundlePlugin\Repository;

use Sylius\Component\Product\Repository\ProductVariantRepositoryInterface as BaseProductVariantRepositoryInterface;

interface ProductVariantRepositoryInterface extends BaseProductVariantRepositoryInterface
{
    public function findByPhrase(
        string $phrase,
        string $locale,
        ?int $limit = null,
    ): array;

    public function findByCodes(array $codes): array;
}
