<?php

declare(strict_types=1);

namespace App\Services\Galactus\Facades;

use App\Services\Galactus\GalactusService;
use Illuminate\Support\Facades\Facade;

/** @see GalactusService */
class Galactus extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'galactus';
    }
}
