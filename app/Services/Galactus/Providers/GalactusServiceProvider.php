<?php

declare(strict_types=1);

namespace App\Services\Galactus\Providers;

use App\Services\Galactus\GalactusService;
use Illuminate\Support\ServiceProvider;
use GuzzleHttp\Client;

class GalactusServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('galactus', static function () {
            $client = new Client([
                'base_uri' => config('services.galactus.baseUri'),
                'auth' => [
                    config('services.galactus.username'),
                    config('services.galactus.password'),
                ],
            ]);

            return new GalactusService($client);
        });
    }
}
