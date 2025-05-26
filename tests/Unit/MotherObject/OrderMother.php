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

namespace Tests\BitBag\SyliusProductBundlePlugin\Unit\MotherObject;

use Sylius\Component\Core\Model\ChannelInterface;
use Sylius\Component\Core\Model\Order;
use Sylius\Component\Core\Model\OrderInterface;

final class OrderMother
{
    public static function create(): OrderInterface
    {
        return new Order();
    }

    public static function createWithId(int $id): OrderInterface
    {
        $order = self::create();

        $setIdClosure = function (int $id): void {
            /** @phpstan-ignore-next-line  */
            $this->id = $id;
        };
        ($setIdClosure->bindTo($order, $order))($id);

        return $order;
    }

    public static function createWithChannel(ChannelInterface $channel): OrderInterface
    {
        $order = self::create();

        $order->setChannel($channel);

        return $order;
    }
}
