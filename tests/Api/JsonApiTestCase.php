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

namespace Tests\BitBag\SyliusProductBundlePlugin\Api;

use ApiTestCase\JsonApiTestCase as BaseJsonApiTestCase;
use Symfony\Component\DependencyInjection\Container;

abstract class JsonApiTestCase extends BaseJsonApiTestCase
{
    public const DEFAULT_HEADER = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    public const PATCH_HEADER = ['CONTENT_TYPE' => 'application/merge-patch+json', 'HTTP_ACCEPT' => 'application/ld+json'];

    protected static function getContainer(): Container
    {
        if (is_callable('parent::getContainer')) {
            /* @phpstan-ignore-next-line */
            return parent::getContainer();
        }

        return self::$container;
    }
}
