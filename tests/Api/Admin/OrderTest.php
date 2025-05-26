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

namespace Tests\BitBag\SyliusProductBundlePlugin\Api\Admin;

use Sylius\Component\Core\Model\OrderInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Tests\BitBag\SyliusProductBundlePlugin\Api\AdminJsonApiTestCase;

final class OrderTest extends AdminJsonApiTestCase
{
    private const ENDPOINT_ORDERS_ITEM = '/api/v2/admin/orders/%s';

    /** @var array|object[] */
    private $fixtures = [];

    /** @var array|string[] */
    private $authHeaders = [];

    protected function setUp(): void
    {
        $this->fixtures = $this->loadFixturesFromFiles([
            'general/channels.yml',
            'general/authentication.yml',
            'shop/product_bundles.yml',
            'shop/orders.yml',
        ]);

        $authToken = $this->getAuthToken('api@example.com', 'sylius-api');
        $this->authHeaders = $this->getHeaders($authToken);
    }

    /** @test */
    public function it_gets_order_data_containing_info_about_bundled_items(): void
    {
        /** @var OrderInterface $order */
        $order = $this->fixtures['order_with_bundle'];

        $this->client->request(
            Request::METHOD_GET,
            sprintf(self::ENDPOINT_ORDERS_ITEM, $order->getTokenValue()),
            [],
            [],
            $this->authHeaders,
        );
        $response = $this->client->getResponse();

        $this->assertResponse($response, 'admin/get_order_with_bundle_response', Response::HTTP_OK);
    }
}
