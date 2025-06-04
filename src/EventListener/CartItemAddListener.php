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

namespace Sylius\ProductBundlePlugin\EventListener;

use Sylius\Bundle\OrderBundle\Controller\AddToCartCommandInterface;
use Sylius\Component\Order\Modifier\OrderModifierInterface;
use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDtoInterface;
use Symfony\Component\EventDispatcher\GenericEvent;

final readonly class CartItemAddListener
{
    public function __construct(
        private OrderModifierInterface $orderModifier,
    ) {
    }

    public function addToOrder(GenericEvent $event): void
    {
        $addToCartCommand = $event->getSubject();

        if (
            false === $addToCartCommand instanceof AddProductBundleToCartDtoInterface &&
            false === $addToCartCommand instanceof AddToCartCommandInterface
        ) {
            return;
        }

        $this->orderModifier->addToOrder($addToCartCommand->getCart(), $addToCartCommand->getCartItem());
    }
}
