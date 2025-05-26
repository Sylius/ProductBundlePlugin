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

namespace BitBag\SyliusProductBundlePlugin\Factory;

use BitBag\SyliusProductBundlePlugin\Command\AddProductBundleToCartCommand;
use BitBag\SyliusProductBundlePlugin\Dto\AddProductBundleToCartDtoInterface;

final class AddProductBundleToCartCommandFactory implements AddProductBundleToCartCommandFactoryInterface
{
    public function createNew(
        int $orderId,
        string $productCode,
        int $quantity,
    ): AddProductBundleToCartCommand {
        return new AddProductBundleToCartCommand($orderId, $productCode, $quantity);
    }

    public function createFromDto(AddProductBundleToCartDtoInterface $dto): AddProductBundleToCartCommand
    {
        $cartId = $dto->getCart()->getId();
        $productCode = $dto->getProduct()->getCode() ?? '';
        $quantity = $dto->getCartItem()->getQuantity();

        return $this->createNew($cartId, $productCode, $quantity);
    }
}
