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

namespace Sylius\ProductBundlePlugin\Twig\Component\Product;

use Sylius\Bundle\ShopBundle\Twig\Component\Product\AddToCartFormComponent as BaseAddToCartFormComponent;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Factory\AddProductBundleToCartDtoFactoryInterface;
use Sylius\ProductBundlePlugin\Form\Type\AddProductBundleToCartType;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

class AddToCartFormComponent extends BaseAddToCartFormComponent
{
    use ComponentWithFormTrait;

    protected AddProductBundleToCartDtoFactoryInterface $addProductBundleToCartDtoFactory;

    protected ?string $bundleFormClass = null;

    public function setAddProductBundleToCartDtoFactory(
        AddProductBundleToCartDtoFactoryInterface $addProductBundleToCartDtoFactory,
    ): void {
        $this->addProductBundleToCartDtoFactory = $addProductBundleToCartDtoFactory;
    }

    public function setBundleFormClass(?string $bundleFormClass): void
    {
        $this->bundleFormClass = $bundleFormClass;
    }

    protected function instantiateForm(): FormInterface
    {
        /** @var ProductInterface $product */
        $product = $this->product;
        if (!$product->isBundle()) {
            return parent::instantiateForm();
        }

        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->cartItemFactory->createForProduct($product);
        /** @var ProductInterface $orderProduct */
        $orderProduct = $orderItem->getProduct();

        $addToCartCommand = $this->addProductBundleToCartDtoFactory->createNew(
            $this->cartContext->getCart(),
            $orderItem,
            $orderProduct,
        );

        return $this->formFactory->create(
            $this->bundleFormClass ?? AddProductBundleToCartType::class,
            $addToCartCommand,
            ['product' => $product],
        );
    }
}
