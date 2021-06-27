<?php

namespace App\Helper;

use Symfony\Component\HttpFoundation\ParameterBag;

class RequestBodyResolver
{
    public static function resolve($request): ParameterBag
    {
        return new ParameterBag(json_decode($request->getContent(), true));
    }
}
