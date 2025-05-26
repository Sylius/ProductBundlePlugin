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

use BitBag\SyliusProductBundlePlugin\Command\AddProductBundleToCartCommand;
use BitBag\SyliusProductBundlePlugin\Factory\AddProductBundleToCartCommandFactory;
use PHPUnit\Framework\TestCase;
use Tests\BitBag\SyliusProductBundlePlugin\Unit\MotherObject\AddProductBundleToCartDtoMother;

final class AddProductBundleToCartCommandFactoryTest extends TestCase
{
    public const ORDER_ID = 5;

    public const PRODUCT_CODE = 'MY_PRODUCT';

    public const QUANTITY = 2;

    public function testCreateAddProductBundleToCartCommandObject(): void
    {
        $factory = new AddProductBundleToCartCommandFactory();
        $command = $factory->createNew(self::ORDER_ID, self::PRODUCT_CODE, self::QUANTITY);

        self::assertInstanceOf(AddProductBundleToCartCommand::class, $command);
        self::assertEquals(self::ORDER_ID, $command->getOrderId());
        self::assertEquals(self::PRODUCT_CODE, $command->getProductCode());
        self::assertEquals(self::QUANTITY, $command->getQuantity());
    }

    public function testCreateAddProductBundleToCartCommandObjectFromDto(): void
    {
        $dto = AddProductBundleToCartDtoMother::createWithOrderIdAndProductCode(self::ORDER_ID, self::PRODUCT_CODE);

        $factory = new AddProductBundleToCartCommandFactory();
        $command = $factory->createFromDto($dto);

        self::assertInstanceOf(AddProductBundleToCartCommand::class, $command);
        self::assertEquals(self::ORDER_ID, $command->getOrderId());
        self::assertEquals(self::PRODUCT_CODE, $command->getProductCode());
        self::assertEquals(0, $command->getQuantity());
    }
}
