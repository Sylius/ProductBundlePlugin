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

use Sylius\Bundle\AdminBundle\Twig\Component\Product\FormComponent as BaseFormComponent;
use Sylius\Bundle\UiBundle\Twig\Component\LiveCollectionTrait;
use Sylius\Bundle\UiBundle\Twig\Component\ResourceFormComponentTrait;
use Sylius\Bundle\UiBundle\Twig\Component\TemplatePropTrait;
use Sylius\Component\Core\Model\ProductInterface;
use Sylius\Component\Resource\Model\ResourceInterface;
use Sylius\ProductBundlePlugin\Factory\ProductFactoryInterface as PluginProductFactoryInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\UX\LiveComponent\Attribute\AsLiveComponent;
use Symfony\UX\LiveComponent\Attribute\LiveProp;
use Symfony\UX\LiveComponent\ComponentToolsTrait;
use Webmozart\Assert\Assert;

#[AsLiveComponent]  // dziedziczy alias i tagi z rodzica
class FormComponent extends BaseFormComponent
{
    use ComponentToolsTrait;
    use LiveCollectionTrait;
    use TemplatePropTrait;

    /** @use ResourceFormComponentTrait<ProductInterface> */
    use ResourceFormComponentTrait;

    #[LiveProp(writable: false)]
    public bool $isBundle = false;

    protected function instantiateForm(): FormInterface
    {
        return $this->formFactory->create($this->formClass, $this->resource);
    }

    protected function createResource(): ResourceInterface
    {
        if ($this->isBundle) {
            Assert::isInstanceOf($this->productFactory, PluginProductFactoryInterface::class);

            return $this->productFactory->createWithVariantAndBundle();
        }

        return parent::createResource();
    }

    protected function getDataModelValue(): string
    {
        return 'norender|*';
    }
}
