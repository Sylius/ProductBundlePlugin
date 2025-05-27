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

namespace Sylius\ProductBundlePlugin\Handler\Api;

use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\ProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;
use Sylius\ProductBundlePlugin\Entity\ProductBundleInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Handler\AddProductBundleToCartHandler\CartProcessorInterface;
use Symfony\Component\Messenger\Attribute\AsMessageHandler;
use Webmozart\Assert\Assert;

#[AsMessageHandler]
final readonly class AddProductBundleToCartHandler
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
        private ProductRepositoryInterface $productRepository,
        private CartProcessorInterface $cartProcessor,
    ) {
    }

    public function __invoke(AddProductBundleToCartDto $addProductBundleToCartCommand): OrderInterface
    {
        /** @var OrderInterface|null $cart */
        $cart = $this->orderRepository->findCartByTokenValue($addProductBundleToCartCommand->getOrderTokenValue());
        Assert::notNull($cart);

        /** @var ProductInterface|null $product */
        $product = $this->productRepository->findOneByCode($addProductBundleToCartCommand->getProductCode());
        Assert::notNull($product);
        Assert::true($product->isBundle());

        /** @var ProductBundleInterface|null $productBundle */
        $productBundle = $product->getProductBundle();
        Assert::notNull($productBundle);

        $quantity = $addProductBundleToCartCommand->getQuantity();
        Assert::greaterThan($quantity, 0);

        $this->cartProcessor->process($cart, $productBundle, $quantity);

        return $cart;
    }
}
