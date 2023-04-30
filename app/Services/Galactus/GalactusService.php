<?php

declare(strict_types=1);

namespace App\Services\Galactus;

use GuzzleHttp\Client;

class GalactusService
{
    public function __construct(protected Client $client)
    {
    }

    public function getKid(string $email): string
    {
        $response = $this->client->get('kid', [
            'email' => $email,
        ])->getBody()->getContents();

        return $response['kid'] ?? '';
    }
}
