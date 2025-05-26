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

namespace Sylius\ProductBundlePlugin\EventListener;

use Sylius\Bundle\ResourceBundle\Event\ResourceControllerEvent;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;

final class AddProductToProductBundleWhenEditNormalProductEventListener
{
    public function addProductToProductBundle(ResourceControllerEvent $resourceControllerEvent): void
    {
        /** @var ProductInterface $product */
        $product = $resourceControllerEvent->getSubject();

        $bundle = $product->getProductBundle();

        if (null !== $bundle && null === $bundle->getProduct()) {
            $bundle->setProduct($product);
        }
    }
}
