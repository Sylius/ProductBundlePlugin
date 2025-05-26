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

namespace Sylius\ProductBundlePlugin\Form\Type;

use Sylius\ProductBundlePlugin\Dto\AddProductBundleToCartDto;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\Bundle\OrderBundle\Form\Type\CartItemType;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\CollectionType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

final class AddProductBundleToCartType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->add('cartItem', CartItemType::class, [
                'product' => $options['product'],
            ])
            ->add('productBundleItems', CollectionType::class, [
                'entry_type' => AddProductBundleItemToCartType::class,
                'entry_options' => [
                    'product' => $options['product'],
                ],
            ])
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver
            ->setDefined([
                'product',
            ])
            ->setAllowedTypes('product', ProductInterface::class)
            ->setDefaults([
                'data_class' => AddProductBundleToCartDto::class,
            ])
        ;
    }

    public function getBlockPrefix(): string
    {
        return 'bitbag_sylius_product_bundle_plugin_add_product_bundle_to_cart';
    }
}
