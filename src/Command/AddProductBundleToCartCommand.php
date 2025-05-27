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

namespace Sylius\ProductBundlePlugin\Command;

final class AddProductBundleToCartCommand implements OrderIdentityAwareInterface, ProductCodeAwareInterface
{
    public function __construct(
        private int $orderId,
        private string $productCode,
        private int $quantity = 1,
    ) {
    }

    public function getOrderId(): int
    {
        return $this->orderId;
    }

    public function getProductCode(): string
    {
        return $this->productCode;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
