<?php

namespace App\Core\Core\Facades;

use Illuminate\Support\Facades\Facade;

class Platform extends Facade
{
    protected static function getFacadeAccessor()
    {
        return 'platform';
    }
}
