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

namespace Tests\BitBag\SyliusProductBundlePlugin\Unit\EventListener;

use BitBag\SyliusProductBundlePlugin\Entity\ProductBundleInterface;
use BitBag\SyliusProductBundlePlugin\EventListener\AddProductToProductBundleWhenEditNormalProductEventListener;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;
use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Tests\BitBag\SyliusProductBundlePlugin\Entity\Product;

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

        $event
            ->expects($this->once())
            ->method('getSubject')
            ->willReturn($product);

        // product has no bundle
        $product
            ->expects($this->once())
            ->method('getProductBundle')
            ->willReturn(null);

        // Should not throw or call bundle methods
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

        $event
            ->expects($this->once())
            ->method('getSubject')
            ->willReturn($product);

        // getProductBundle() called twice: once for assignment, once for setter
        $product
            ->expects($this->exactly(2))
            ->method('getProductBundle')
            ->willReturn($bundle);

        // Bundle has no product
        $bundle
            ->expects($this->once())
            ->method('getProduct')
            ->willReturn(null);

        // Expect setProduct() on the bundle instance
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
        /** @var ProductBundleInterface|MockObject $bundle */
        $bundle = $this->createMock(ProductBundleInterface::class);
        /** @var Product|MockObject $existingProduct */
        $existingProduct = $this->getMockBuilder(Product::class)
            ->disableOriginalConstructor()
            ->getMock();

        $event
            ->expects($this->once())
            ->method('getSubject')
            ->willReturn($product);

        // getProductBundle() called once (assignment)
        $product
            ->expects($this->once())
            ->method('getProductBundle')
            ->willReturn($bundle);

        // Bundle already has a product
        $bundle
            ->expects($this->once())
            ->method('getProduct')
            ->willReturn($existingProduct);

        // setProduct() should never be called
        $bundle
            ->expects($this->never())
            ->method('setProduct');

        $this->listener->addProductToProductBundle($event);
    }
}
