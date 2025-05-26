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

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Component\Core\Model\ProductVariant;
use Sylius\Component\Resource\Factory\FactoryInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleItem;
use Sylius\ProductBundlePlugin\Entity\ProductBundleOrderItem;
use Sylius\ProductBundlePlugin\Factory\ProductBundleOrderItemFactory;

final class ProductBundleOrderItemFactoryTest extends TestCase
{
    private const PRODUCT_VARIANT_CODE = 'MY_VARIANT';

    /** @var mixed|MockObject|FactoryInterface */
    private $baseProductBundleOrderItemFactory;

    protected function setUp(): void
    {
        $this->baseProductBundleOrderItemFactory = $this->createMock(FactoryInterface::class);
        $this->baseProductBundleOrderItemFactory
            ->method('createNew')
            ->willReturn(new ProductBundleOrderItem())
        ;
    }

    public function testCreateProductBundleOrderItemFromProductBundleItem(): void
    {
        $factory = new ProductBundleOrderItemFactory($this->baseProductBundleOrderItemFactory);

        $productVariant = new ProductVariant();
        $productVariant->setCode(self::PRODUCT_VARIANT_CODE);

        $productBundleItem = new ProductBundleItem();
        $productBundleItem->setProductVariant($productVariant);
        $productBundleItem->setQuantity(2);

        $orderItem = $factory->createFromProductBundleItem($productBundleItem);
        $orderItemProductVariant = $orderItem->getProductVariant();

        self::assertEquals($productBundleItem, $orderItem->getProductBundleItem());
        self::assertSame($productBundleItem->getQuantity(), $orderItem->getQuantity());
        self::assertSame($productVariant->getCode(), $orderItemProductVariant->getCode());
    }
}
