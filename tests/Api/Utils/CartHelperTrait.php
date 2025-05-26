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

namespace Tests\BitBag\SyliusProductBundlePlugin\Api\Utils;

use Sylius\Bundle\ApiBundle\Command\Cart\PickupCart;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Order\Model\OrderInterface;
use Symfony\Component\Messenger\MessageBusInterface;

trait CartHelperTrait
{
    public function createCart(string $tokenValue): void
    {
        /** @var MessageBusInterface $commandBus */
        $commandBus = self::getContainer()->get('sylius.command_bus');

        $command = new PickupCart('WEB', 'en_US', null, $tokenValue, );

        $commandBus->dispatch($command);
    }

    public function findCart(string $tokenValue): ?OrderInterface
    {
        /** @var OrderRepositoryInterface $orderManager */
        $orderManager = self::getContainer()->get('sylius.repository.order');

        return $orderManager->findCartByTokenValue($tokenValue);
    }
}
