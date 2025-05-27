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

namespace Sylius\ProductBundlePlugin;

use Sylius\Bundle\CoreBundle\Application\SyliusPluginTrait;
use Sylius\ProductBundlePlugin\DependencyInjection\CompilerPass\AuthenticationManagerPolyfillPass;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\HttpKernel\Bundle\Bundle;

final class SyliusProductBundlePlugin extends Bundle
{
    use SyliusPluginTrait;

    public function getPath(): string
    {
        return \dirname(__DIR__);
    }

    public function build(ContainerBuilder $container): void
    {
        $container->addCompilerPass(new AuthenticationManagerPolyfillPass());

        parent::build($container);
    }
}
