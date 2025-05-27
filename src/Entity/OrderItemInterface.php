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

namespace Sylius\ProductBundlePlugin\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Sylius\Component\Core\Model\OrderItemInterface as BaseOrderItemInterface;

interface OrderItemInterface extends BaseOrderItemInterface
{
    public function addProductBundleOrderItem(ProductBundleOrderItemInterface $productBundleOrderItem): void;

    /** @return ProductBundleOrderItemInterface[]|ArrayCollection */
    public function getProductBundleOrderItems();
}
