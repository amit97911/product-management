<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\Tradeling;

class ProductApiController extends Controller
{
    public function createProduct()
    {
        if ((new ApiKey)->isExpiredTradeling('tradeling')) {
            (new Tradeling)->generateAPIToken();
        }

        return ApiKey::where('name', 'tradeling')->first();
    }
}
