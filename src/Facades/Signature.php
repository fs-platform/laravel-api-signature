<?php

namespace Aron\Signature\Facades;

use Illuminate\Support\Facades\Facade;

class Signature extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Signature';
    }
}
