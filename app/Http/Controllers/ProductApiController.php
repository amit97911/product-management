<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\LevelZeroCategory;
use App\Models\Tradeling;

class ProductApiController extends Controller
{
    public function createProduct()
    {
        if ((new ApiKey)->isExpiredTradeling('tradeling')) {
            (new Tradeling)->generateAPIToken();
        }

        return (new LevelZeroCategory)->with('levelOneCategories.levelTwoCategories.levelThreeCategories')->get();

        return (new LevelThreeCategory)->with('levelTwoCategory.levelOneCategory.levelZeroCategory')->get();

        return ApiKey::where('name', 'tradeling')->first();
    }
}
