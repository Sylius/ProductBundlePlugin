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

namespace Tests\Sylius\ProductBundlePlugin\Unit\Validator;

use PHPUnit\Framework\MockObject\MockObject;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Sylius\Component\Core\Repository\ProductRepositoryInterface;
use Sylius\ProductBundlePlugin\Command\AddProductBundleToCartCommand;
use Sylius\ProductBundlePlugin\Entity\ProductInterface;
use Sylius\ProductBundlePlugin\Validator\HasProductBundle;
use Sylius\ProductBundlePlugin\Validator\HasProductBundleValidator;
use Symfony\Component\Validator\Exception\UnexpectedValueException;
use Symfony\Component\Validator\Test\ConstraintValidatorTestCase;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductBundleMother;
use Tests\Sylius\ProductBundlePlugin\Unit\MotherObject\ProductMother;

final class HasProductBundleTest extends ConstraintValidatorTestCase
{
    private const ORDER_ID = 5;

    private const PRODUCT_CODE = 'MY_PRODUCT';

    private MockObject|OrderRepositoryInterface $productRepository;

    protected function setUp(): void
    {
        $this->productRepository = $this->createMock(ProductRepositoryInterface::class);

        parent::setUp();
    }

    public function testThrowExceptionIfValueIsNotImplementingProductCodeAwareInterface(): void
    {
        $this->expectException(UnexpectedValueException::class);

        $value = new \stdClass();
        $constraint = new HasProductBundle();

        $this->validator->validate($value, $constraint);
    }

    /**
     * @dataProvider pessimisticDataProvider
     */
    public function testPessimisticCase(?ProductInterface $product, ?string $violationMessage): void
    {
        $this->productRepository
            ->expects(self::once())
            ->method('findOneByCode')
            ->with(self::PRODUCT_CODE)
            ->willReturn($product)
        ;

        $value = new AddProductBundleToCartCommand(self::ORDER_ID, self::PRODUCT_CODE);
        $constraint = new HasProductBundle();

        $this->validator->validate($value, $constraint);

        if (null !== $violationMessage) {
            $this->buildViolation($violationMessage)->assertRaised();
        } else {
            $this->assertNoViolation();
        }
    }

    public function pessimisticDataProvider(): array
    {
        return [
            'product is a null' => [null, HasProductBundle::PRODUCT_DOESNT_EXIST_MESSAGE],
            'product is not a bundle' => [ProductMother::create(), HasProductBundle::NOT_A_BUNDLE_MESSAGE],
            'product is a bundle' => [ProductMother::createWithBundle(ProductBundleMother::create()), null],
        ];
    }

    protected function createValidator(): HasProductBundleValidator
    {
        return new HasProductBundleValidator($this->productRepository);
    }
}
