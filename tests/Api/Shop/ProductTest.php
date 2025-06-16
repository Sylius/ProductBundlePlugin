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

namespace Tests\Sylius\ProductBundlePlugin\Api\Shop;

use Sylius\Bundle\CoreBundle\SyliusCoreBundle;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\Sylius\ProductBundlePlugin\Api\JsonApiTestCase;

final class ProductTest extends JsonApiTestCase
{
    private const ENDPOINT_PRODUCTS_ITEM = '/api/v2/shop/products/%s';

    private const ENDPOINT_PRODUCTS_ITEM_PRODUCT_BUNDLE = '/api/v2/shop/products/%s/bundle';

    protected function setUp(): void
    {
        $this->loadFixturesFromFiles(['general/channels.yml', 'shop/product_bundles.yml']);
    }

    /** @test */
    public function it_gets_bundled_product(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            sprintf(self::ENDPOINT_PRODUCTS_ITEM, 'WHISKEY_DOUBLE_PACK'),
            [],
            [],
            self::DEFAULT_HEADER,
        );
        $response = $this->client->getResponse();

        if (SyliusCoreBundle::VERSION_ID < 20100) {
            $filename = 'shop/sylius_20/get_bundled_product_response';
        }

        $this->assertResponse($response, $filename ?? 'shop/get_bundled_product_response', Response::HTTP_OK);
    }

    /** @test */
    public function it_gets_not_bundled_product(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            sprintf(self::ENDPOINT_PRODUCTS_ITEM, 'JOHNNY_WALKER_BLACK'),
            [],
            [],
            self::DEFAULT_HEADER,
        );
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'shop/get_not_bundled_product_response', Response::HTTP_OK);
    }

    /** @test */
    public function it_gets_product_bundle_as_a_subresource(): void
    {
        $this->client->request(
            Request::METHOD_GET,
            sprintf(self::ENDPOINT_PRODUCTS_ITEM_PRODUCT_BUNDLE, 'WHISKEY_DOUBLE_PACK'),
            [],
            [],
            self::DEFAULT_HEADER,
        );
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'shop/get_product_bundle_response', Response::HTTP_OK);
    }
}
