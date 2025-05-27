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

namespace Sylius\ProductBundlePlugin\Validator;

use Symfony\Component\Validator\Constraints\Composite;

final class Sequentially extends Composite
{
    public function __construct(public ?array $constraints = null)
    {
        parent::__construct($constraints ?? []);
    }

    public function getDefaultOption(): string
    {
        return 'constraints';
    }

    public function getRequiredOptions(): array
    {
        return ['constraints'];
    }

    protected function getCompositeOption(): string
    {
        return 'constraints';
    }

    public function getTargets(): array|string
    {
        return [self::CLASS_CONSTRAINT, self::PROPERTY_CONSTRAINT];
    }

    public function validatedBy(): string
    {
        return 'sylius_product_bundle_validator_sequentially';
    }
}
