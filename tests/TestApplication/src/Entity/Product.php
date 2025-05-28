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

namespace Tests\Sylius\ProductBundlePlugin\Entity;

use Doctrine\ORM\Mapping as ORM;
use Sylius\ProductBundlePlugin\Entity\ProductBundlesAwareTrait;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\Component\Core\Model\Product as BaseProduct;

#[ORM\Entity]
#[ORM\Table(name: 'sylius_product')]
class Product extends BaseProduct implements ProductInterface
{
    use ProductBundlesAwareTrait;
}
