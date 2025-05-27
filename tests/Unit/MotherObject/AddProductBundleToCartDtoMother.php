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

use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDto;

final class AddProductBundleToCartDtoMother
{
    public static function create(): AddProductBundleToCartDto
    {
        $order = OrderMother::create();
        $orderItem = OrderItemMother::create();
        $product = ProductMother::create();
        $productBundleItems = [];

        return new AddProductBundleToCartDto($order, $orderItem, $product, $productBundleItems);
    }

    public static function createWithOrderIdAndProductCode(int $orderId, string $productCode): AddProductBundleToCartDto
    {
        $order = OrderMother::createWithId($orderId);
        $orderItem = OrderItemMother::create();
        $product = ProductMother::createWithCode($productCode);
        $productBundleItems = [];

        return new AddProductBundleToCartDto($order, $orderItem, $product, $productBundleItems);
    }
}
