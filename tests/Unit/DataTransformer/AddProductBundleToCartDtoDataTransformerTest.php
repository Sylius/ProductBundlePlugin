<?php

/*
 * This file is part of the Sylius ProductBundle Plugin package.
 *
 * (c) Sylius Sp. z o.o.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

/*
 * This file was created by developers working at BitBag
 * Do you need more information about us and what we do? Visit our https://bitbag.io website!
 * We are hiring developers from all over the world. Join us and start your new, exciting adventure and become part of us: https://bitbag.io/career
 */

declare(strict_types=1);

namespace Tests\Sylius\ProductBundlePlugin\Unit\DataTransformer;

use Sylius\ProductBundlePlugin\Command\AddProductBundleToCartCommand;
use Sylius\ProductBundlePlugin\DataTransformer\AddProductBundleToCartDtoDataTransformer;
use Sylius\ProductBundlePlugin\Dto\Api\AddProductBundleToCartDto;
use PHPUnit\Framework\TestCase;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\Api\AddProductBundleToCartDtoMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\OrderMother;
use Tests\Sylius\ProductBundlePlugin\Unit\TypeExceptionMessage;
use Webmozart\Assert\InvalidArgumentException;

final class AddProductBundleToCartDtoDataTransformerTest extends TestCase
{
    private const PRODUCT_CODE = 'PRODUCT_CODE';

    private const ORDER_TOKEN_VALUE = 'ORDER_TOKEN_VALUE';

    private const QUANTITY = 2;

    public function testThrowErrorIfObjectIsNotInstanceOfAddProductBundleToCartDto(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(
            sprintf(TypeExceptionMessage::EXPECTED_INSTANCE_OF_X_GOT_Y, AddProductBundleToCartDto::class, \stdClass::class),
        );

        $object = new \stdClass();
        $dataTransformer = new AddProductBundleToCartDtoDataTransformer();

        $dataTransformer->transform($object, '');
    }

    public function testThrowIfObjectToPopulateDoesntExist(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage(TypeExceptionMessage::EXPECTED_VALUE_OTHER_THAN_NULL);

        $object = AddProductBundleToCartDtoMother::create(
            self::PRODUCT_CODE,
            self::ORDER_TOKEN_VALUE,
            self::QUANTITY,
        );
        $dataTransformer = new AddProductBundleToCartDtoDataTransformer();

        $dataTransformer->transform($object, '');
    }

    public function testReturnAddProductBundleToCart(): void
    {
        $object = AddProductBundleToCartDtoMother::create(
            self::PRODUCT_CODE,
            self::ORDER_TOKEN_VALUE,
            self::QUANTITY,
        );
        $context = [
            AddProductBundleToCartDtoDataTransformer::OBJECT_TO_POPULATE => OrderMother::createWithId(3),
        ];
        $dataTransformer = new AddProductBundleToCartDtoDataTransformer();

        $addProductBundleToCartCommand = $dataTransformer->transform($object, '', $context);

        self::assertInstanceOf(AddProductBundleToCartCommand::class, $addProductBundleToCartCommand);
        self::assertSame('PRODUCT_CODE', $addProductBundleToCartCommand->getProductCode());
        self::assertSame(2, $addProductBundleToCartCommand->getQuantity());
        self::assertSame(3, $addProductBundleToCartCommand->getOrderId());
    }
}
