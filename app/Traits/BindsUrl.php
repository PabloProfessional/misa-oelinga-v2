<?php

namespace App\Traits;

use Illuminate\Support\Facades\Route;

trait BindsUrl
{
    // This trait binds url to the ID so that I use url to fetch a model.
    public function bindUrl($modelClass, $parameterName = 'url', $routeKey = 'url')
    {
        Route::bind($parameterName, function ($value) use ($modelClass, $routeKey) {
            return $modelClass::where($routeKey, $value)->firstOrFail();
        });
    }
}
