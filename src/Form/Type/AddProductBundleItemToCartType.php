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

namespace BitBag\SyliusProductBundlePlugin\Form\Type;

use BitBag\SyliusProductBundlePlugin\Command\AddProductBundleItemToCartCommand;
use BitBag\SyliusProductBundlePlugin\Entity\ProductInterface;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantChoiceType;
use Sylius\Bundle\ProductBundle\Form\Type\ProductVariantMatchType;
use Sylius\Component\Core\Model\Product;
use Sylius\Component\Core\Model\ProductVariantInterface;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvent;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddProductBundleItemToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        /** @var ProductInterface $product */
        $product = $options['product'];

        if (null !== $product->getProductBundle() && $product->getProductBundle()->isPackedProduct()) {
            return;
        }

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (FormEvent $event): void {
            /** @var AddProductBundleItemToCartCommand $data */
            $data = $event->getData();

            $form = $event->getForm();

            /** @var ProductVariantInterface|null $productVariant */
            $productVariant = $data->getProductVariant();
            assert(null !== $productVariant);

            /** @var ProductInterface|null $product */
            $product = $productVariant->getProduct();
            assert(null !== $product);

            if ($product->hasVariants() && !$product->isSimple()) {
                $type =
                    Product::VARIANT_SELECTION_CHOICE === $product->getVariantSelectionMethod()
                        ? ProductVariantChoiceType::class
                        : ProductVariantMatchType::class
                ;

                $form->add('productVariant', $type, [
                    'product' => $product,
                    'label' => false,
                ]);
            }
        });
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined([
                'product',
            ])
            ->setAllowedTypes('product', ProductInterface::class)
            ->setDefaults([
                'data_class' => AddProductBundleItemToCartCommand::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_product_bundle_plugin_add_product_bundle_item_to_cart';
    }
}
