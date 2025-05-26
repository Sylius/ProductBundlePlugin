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

use BitBag\SyliusProductBundlePlugin\Command\AddProductBundleItemToCartCommand;
use BitBag\SyliusProductBundlePlugin\Factory\AddProductBundleItemToCartCommandFactory;
use PHPUnit\Framework\TestCase;
use Tests\BitBag\SyliusProductBundlePlugin\Unit\MotherObject\ProductBundleItemMother;

final class AddProductBundleItemToCartCommandFactoryTest extends TestCase
{
    public function testCreateAddProductBundleItemToCartCommand(): void
    {
        $productBundleItem = ProductBundleItemMother::create();

        $factory = new AddProductBundleItemToCartCommandFactory();
        $command = $factory->createNew($productBundleItem);

        self::assertInstanceOf(AddProductBundleItemToCartCommand::class, $command);
    }
}
