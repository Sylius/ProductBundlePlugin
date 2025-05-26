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

namespace Tests\BitBag\SyliusProductBundlePlugin\Behat\Page\Admin;

use Sylius\Behat\Page\Admin\Crud\CreatePageInterface;
use Sylius\Component\Core\Model\ChannelInterface;

interface CreateBundledProductPageInterface extends CreatePageInterface
{
    public function specifyCode(string $code): void;

    public function nameItIn(string $name, string $localeCode): void;

    public function specifySlugIn(?string $slug, string $locale): void;

    public function specifyPrice(ChannelInterface $channel, string $price): void;

    public function specifyOriginalPrice(ChannelInterface $channel, int $originalPrice): void;

    public function addProductsToBundle(array $productsNames): void;
}
