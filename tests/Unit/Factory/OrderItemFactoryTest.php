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

namespace Tests\BitBag\SyliusProductBundlePlugin\Unit\Factory;

use BitBag\SyliusProductBundlePlugin\Factory\OrderItemFactory;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\ProductVariant;
use Tests\BitBag\SyliusProductBundlePlugin\Entity\OrderItem;

final class OrderItemFactoryTest extends TestCase
{
    public function testCreateOrderItemWithVariant(): void
    {
        $productVariant = new ProductVariant();
        $orderItem = new OrderItem();

        $baseFactory = $this->createMock(CartItemFactoryInterface::class);
        $baseFactory->expects(self::once())
            ->method('createNew')
            ->willReturn($orderItem)
        ;

        $factory = new OrderItemFactory($baseFactory);
        $orderItemWithVariant = $factory->createWithVariant($productVariant);

        self::assertSame($productVariant, $orderItemWithVariant->getVariant());
    }
}
