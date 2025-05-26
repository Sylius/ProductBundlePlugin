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

namespace Tests\Sylius\ProductBundlePlugin\Api;

abstract class AdminJsonApiTestCase extends JsonApiTestCase
{
    public function getAuthToken(string $email, string $password): string
    {
        $endpoint = '/api/v2/admin/administrators/token';

        $this->client->request(
            'POST',
            $endpoint,
            [],
            [],
            ['CONTENT_TYPE' => 'application/json', 'HTTP_ACCEPT' => 'application/json'],
            json_encode(['email' => $email, 'password' => $password]),
        );

        return json_decode($this->client->getResponse()->getContent(), true)['token'];
    }

    public function getHeaders($authToken = null): array
    {
        $headers = ['CONTENT_TYPE' => 'application/ld+json', 'HTTP_ACCEPT' => 'application/ld+json'];

        if (null === $authToken) {
            return $headers;
        }

        $authorizationHeader = self::getContainer()->getParameter('sylius.api.authorization_header');
        $headers['HTTP_' . $authorizationHeader] = 'Bearer ' . $authToken;

        return $headers;
    }
}
