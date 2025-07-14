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

namespace Sylius\ProductBundlePlugin\Form\Extension;

use Sylius\Bundle\AdminBundle\Form\Type\ProductType;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Form\Type\ProductBundleType;
use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
use Symfony\Component\Validator\Constraints\Valid;

final class ProductTypeExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder->addEventListener(FormEvents::PRE_SET_DATA, function ($event) {
            /** @var ProductInterface $data */
            $data = $event->getData();
            $form = $event->getForm();

            if (true === $data->isBundle()) {
                $form->add('productBundle', ProductBundleType::class, [
                    'label' => false,
                    'constraints' => [new Valid()],
                ]);
            }
        });
    }

    public static function getExtendedTypes(): iterable
    {
        return [ProductType::class];
    }
}
