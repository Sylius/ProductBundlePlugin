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

namespace Tests\Sylius\ProductBundlePlugin\Unit\EventListener;

use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\EventListener\AddProductToProductBundleWhenEditNormalProductEventListener;
use Tests\Sylius\ProductBundlePlugin\Entity\Product;

final class AddProductToProductBundleWhenEditNormalProductEventListenerTest extends TestCase
{
    private AddProductToProductBundleWhenEditNormalProductEventListener $listener;

    protected function setUp(): void
    {
        $this->listener = new AddProductToProductBundleWhenEditNormalProductEventListener();
    }

    public function testDoesNothingWhenNoProductBundle(): void
    {
        /** @var ResourceControllerEvent|MockObject $event */
        $event = $this->createMock(ResourceControllerEvent::class);
        /** @var Product|MockObject $product */
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())->method('getSubject')->willReturn($product);
        $product->expects($this->once())->method('getProductBundle')->willReturn(null);
        $this->listener->addProductToProductBundle($event);

        $this->assertTrue(true, 'No exception means pass');
    }

    public function testSetsProductOnBundleWhenBundleExistsAndNoProduct(): void
    {
        /** @var ResourceControllerEvent|MockObject $event */
        $event = $this->createMock(ResourceControllerEvent::class);
        /** @var Product|MockObject $product */
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();
        /** @var ProductBundleInterface|MockObject $bundle */
        $bundle = $this->createMock(ProductBundleInterface::class);

        $event->expects($this->once())->method('getSubject')->willReturn($product);
        $product->expects($this->once())->method('getProductBundle')->willReturn($bundle);
        $bundle->expects($this->once())->method('getProduct')->willReturn(null);

        $bundle
            ->expects($this->once())
            ->method('setProduct')
            ->with($product);

        $this->listener->addProductToProductBundle($event);
    }

    public function testDoesNotOverrideExistingProductInBundle(): void
    {
        /** @var ResourceControllerEvent|MockObject $event */
        $event = $this->createMock(ResourceControllerEvent::class);
        /** @var Product|MockObject $product */
        $product = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();
        /** @var ProductBundleInterface&MockObject $bundle */
        $bundle = $this->createMock(ProductBundleInterface::class);
        /** @var ProductInterface|MockObject $existingProduct */
        $existingProduct = $this->getMockBuilder(ProductInterface::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event->expects($this->once())->method('getSubject')->willReturn($product);
        $product->expects($this->once())->method('getProductBundle')->willReturn($bundle);
        $bundle->expects($this->once())->method('getProduct')->willReturn($existingProduct);
        $bundle->expects($this->never())->method('setProduct');

        $this->listener->addProductToProductBundle($event);
    }
}
