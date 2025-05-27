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

namespace Tests\Sylius\ProductBundlePlugin\Unit\Factory;

use PHPUnit\Framework\TestCase;
use Sylius\ProductBundlePlugin\Command\AddProductBundleItemToCartCommand;
use Sylius\ProductBundlePlugin\Factory\AddProductBundleItemToCartCommandFactory;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductBundleItemMother;

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
