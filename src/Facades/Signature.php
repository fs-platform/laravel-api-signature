<?php

namespace Aron\Singature\Facades;

use Illuminate\Support\Facades\Facade;

class Signature extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return 'Signature';
    }
}
