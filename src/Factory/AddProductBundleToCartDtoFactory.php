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

namespace Sylius\ProductBundlePlugin\Factory;

use Sylius\ProductBundlePlugin\Command\AddProductBundleItemToCartCommand;
use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDto;
use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDtoInterface;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\Component\Order\Model\OrderInterface;

final class AddProductBundleToCartDtoFactory implements AddProductBundleToCartDtoFactoryInterface
{
    public function __construct(
        private AddProductBundleItemToCartCommandFactoryInterface $addProductBundleItemToCartCommandFactory,
    ) {
    }

    public function createNew(
        OrderInterface $order,
        OrderItemInterface $orderItem,
        ProductInterface $product,
    ): AddProductBundleToCartDtoInterface {
        /** @var ProductBundleInterface $productBundle */
        $productBundle = $product->getProductBundle();
        $processedProductBundleItems = $this->getProcessedProductBundleItems($productBundle);

        return new AddProductBundleToCartDto($order, $orderItem, $product, $processedProductBundleItems);
    }

    /**
     * @return AddProductBundleItemToCartCommand[]
     */
    private function getProcessedProductBundleItems(?ProductBundleInterface $productBundle): array
    {
        $addProductBundleItemToCartCommands = [];

        if (null !== $productBundle) {
            foreach ($productBundle->getProductBundleItems() as $bundleItem) {
                $addProductBundleItemToCartCommands[] = $this->addProductBundleItemToCartCommandFactory->createNew($bundleItem);
            }
        }

        return $addProductBundleItemToCartCommands;
    }
}
