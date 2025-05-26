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

use Sylius\ProductBundlePlugin\Command\OrderIdentityAwareInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Symfony\Component\Validator\Constraint;
use Symfony\Component\Validator\ConstraintValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Webmozart\Assert\Assert;

final class HasExistingCartValidator extends ConstraintValidator
{
    public function __construct(
        private OrderRepositoryInterface $orderRepository,
    ) {
    }

    /**
     * @param OrderIdentityAwareInterface|mixed $value
     * @param HasExistingCart|Constraint $constraint
     */
    public function validate($value, Constraint $constraint): void
    {
        Assert::isInstanceOf($constraint, HasExistingCart::class);

        if (!$value instanceof OrderIdentityAwareInterface) {
            throw new UnexpectedValueException($value, OrderIdentityAwareInterface::class);
        }

        $cart = $this->orderRepository->findCartById($value->getOrderId());

        if (null !== $cart) {
            return;
        }

        $this->context->addViolation(HasExistingCart::CART_DOESNT_EXIST_MESSAGE);
    }
}
