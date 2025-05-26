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

namespace Tests\BitBag\SyliusProductBundlePlugin\Unit\MotherObject\Api;

use BitBag\SyliusProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;

final class AddProductBundleToCartDtoMother
{
    public static function create(string $productCode, int $quantity = 1): AddProductBundleToCartDto
    {
        return new AddProductBundleToCartDto($productCode, $quantity);
    }
}
