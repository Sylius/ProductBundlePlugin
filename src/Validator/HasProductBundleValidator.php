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

use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\ProductBundlePlugin\Command\ProductCodeAwareInterface;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Webmozart\Assert\Assert;

final class HasProductBundleValidator extends ConstraintValidator
{
    public function __construct(
        private readonly ProductRepositoryInterface $productRepository,
    ) {
    }

    /**
     * @param ProductCodeAwareInterface|mixed $value
     */
    public function validate($value, Constraint $constraint): void
    {
        Assert::isInstanceOf($constraint, HasProductBundle::class);

        if (!$value instanceof ProductCodeAwareInterface) {
            throw new UnexpectedValueException($value, ProductCodeAwareInterface::class);
        }

        /** @var ProductInterface|null $product */
        $product = $this->productRepository->findOneByCode($value->getProductCode());

        if (null === $product) {
            $this->context->addViolation(HasProductBundle::PRODUCT_DOESNT_EXIST_MESSAGE);

            return;
        }

        if (null === $product->getProductBundle()) {
            $this->context->addViolation(HasProductBundle::NOT_A_BUNDLE_MESSAGE);
        }
    }
}
