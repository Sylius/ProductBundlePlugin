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

namespace Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\Api;

use Sylius\ProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;

final class AddProductBundleToCartDtoMother
{
    public static function create(string $productCode, string $orderTokenValue, int $quantity = 1): AddProductBundleToCartDto
    {
        return new AddProductBundleToCartDto($productCode, $orderTokenValue, $quantity);
    }
}
