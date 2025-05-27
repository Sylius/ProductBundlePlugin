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

namespace Sylius\ProductBundlePlugin\Twig\Extension;

use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Twig\Environment;
use Twig\Extension\AbstractExtension;
use Twig\TwigFunction;

final class ProductBundleOrderItemExtension extends AbstractExtension
{
    public function __construct(
        private readonly Environment $twig,
    ) {
    }

    public function getFunctions(): array
    {
        return [
            new TwigFunction(
                'sylius_render_product_bundle_order_items',
                $this->renderProductBundleOrderItems(...),
                ['is_safe' => ['html']],
            ),
        ];
    }

    public function renderProductBundleOrderItems(ProductInterface $product): string
    {
        if (!$product->isBundle()) {
            return '';
        }

        $productBundle = $product->getProductBundle();

        if (null === $productBundle) {
            throw new \RuntimeException('Product does not contain a valid product bundle.');
        }

        $items = $productBundle->getProductBundleItems();

        return $this->twig->render('@SyliusProductBundlePlugin/Admin/Order/Show/_productBundleOrderItems.html.twig', [
            'items' => $items,
        ]);
    }
}
