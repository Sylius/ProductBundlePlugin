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

use Doctrine\Persistence\ObjectManager;
use Sylius\Bundle\OrderBundle\Factory\AddToCartCommandFactory;
use Sylius\Bundle\ShopBundle\Twig\Component\Product\AddToCartFormComponent as BaseAddToCartFormComponent;
use Sylius\Component\Core\Factory\CartItemFactoryInterface;
use Sylius\Component\Core\Model\OrderItem;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\Component\Core\Repository\ProductVariantRepositoryInterface;
use Sylius\Component\Order\Context\CartContextInterface;
use Sylius\ProductBundlePlugin\Entity\OrderItemInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Factory\AddProductBundleToCartDtoFactoryInterface;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;
use Symfony\Component\Form\FormFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\HttpFoundation\RequestStack;
use Symfony\Component\Routing\RouterInterface;
use Symfony\UX\LiveComponent\ComponentWithFormTrait;

final class AddToCartFormComponent extends BaseAddToCartFormComponent
{
    use ComponentWithFormTrait;

    /**
     * @param CartItemFactoryInterface<OrderItem> $cartItemFactory
     * @param class-string $formClass
     * @param ProductVariantRepositoryInterface<ProductVariantInterface> $productVariantRepository
     */
    public function __construct(
        FormFactoryInterface $formFactory,
        ObjectManager $manager,
        RouterInterface $router,
        RequestStack $requestStack,
        EventDispatcherInterface $eventDispatcher,
        CartContextInterface $cartContext,
        AddToCartCommandFactory $addToCartCommandFactory,
        CartItemFactoryInterface $cartItemFactory,
        string $formClass,
        ProductRepositoryInterface $productRepository,
        ProductVariantRepositoryInterface $productVariantRepository,
        protected readonly AddProductBundleToCartDtoFactoryInterface $addProductBundleToCartDtoFactory,
    ) {
        $this->initializeProduct($productRepository);
        $this->initializeProductVariant($productVariantRepository);

        parent::__construct(
            $formFactory,
            $manager,
            $router,
            $requestStack,
            $eventDispatcher,
            $cartContext,
            $addToCartCommandFactory,
            $cartItemFactory,
            $formClass,
            $productRepository,
            $productVariantRepository,
        );
    }

    protected function instantiateForm(): FormInterface
    {
        /** @var ProductInterface $product */
        $product = $this->product;

        /** @var OrderItemInterface $orderItem */
        $orderItem = $this->cartItemFactory->createForProduct($product);
        /** @var ProductInterface $orderProduct */
        $orderProduct = $orderItem->getProduct();

        $addToCartCommand = $this->addProductBundleToCartDtoFactory->createNew(
            $this->cartContext->getCart(),
            $orderItem,
            $orderProduct,
        );

        return $this->formFactory->create($this->formClass, $addToCartCommand, ['product' => $product]);
    }
}
