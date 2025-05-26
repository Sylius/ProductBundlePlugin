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

namespace Sylius\ProductBundlePlugin\DataTransformer;

use Sylius\ProductBundlePlugin\Command\AddProductBundleToCartCommand;
use Sylius\ProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;
use Sylius\Component\Order\Model\OrderInterface;
use Webmozart\Assert\Assert;

final class AddProductBundleToCartDtoDataTransformer
{
    public const OBJECT_TO_POPULATE = 'object_to_populate';

    /**
     * @param AddProductBundleToCartDto|object $object
     */
    public function transform(
        $object,
        string $to,
        array $context = [],
    ): AddProductBundleToCartCommand {
        Assert::isInstanceOf($object, AddProductBundleToCartDto::class);

        /** @var OrderInterface|null $cart */
        $cart = $context[self::OBJECT_TO_POPULATE] ?? null;
        Assert::notNull($cart);

        $productCode = $object->getProductCode();
        $quantity = $object->getQuantity();

        return new AddProductBundleToCartCommand($cart->getId(), $productCode, $quantity);
    }

    public function supportsTransformation(
        mixed $data,
        string $to,
        array $context = [],
    ): bool {
        return isset($context['input']['class']) && AddProductBundleToCartDto::class === $context['input']['class'];
    }
}
