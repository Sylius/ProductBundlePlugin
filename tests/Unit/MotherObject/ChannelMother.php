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

use Sylius\Component\Core\Model\Channel;
use Sylius\Component\Core\Model\ChannelInterface;

final class ChannelMother
{
    public static function create(): ChannelInterface
    {
        return new Channel();
    }

    public static function createWithName(string $name): ChannelInterface
    {
        $channel = self::create();

        $channel->setName($name);

        return $channel;
    }
}
