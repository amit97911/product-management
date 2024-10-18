<?php

namespace App\Http\Controllers;

use App\Models\ApiKey;
use App\Models\LevelZeroCategory;
use App\Models\Tradeling;
use Carbon\Carbon;

class ProductApiController extends Controller
{
    public function createProduct()
    {
        $this->authenticate();

        // return (new LevelZeroCategory)->with(['levelOneCategories.levelTwoCategories' => function ($query) {
        //     $query->where('category_id', '5fbfd7f08cfcfa9a6f3a7506');
        // }, 'levelOneCategories.levelTwoCategories.levelThreeCategories'])->get();

        // return (new LevelThreeCategory)->with(['levelTwoCategory' => function ($query) {
        //     $query->where('category_id', '5fbfd7f08cfcfa9a6f3a7506');
        // }, 'levelTwoCategory.levelOneCategory.levelZeroCategory'])->get();

        $product_data = [];
        $product_data['sku'] = 'RAVSAM1';
        $product_data['categoryId'] = '6268dc504070ea001b647c50';
        $product_data['stockQty'] = 20;
        $product_data['price'] = 16.12;
        $product_data['unit'] = 'g';
        $product_data['dimensions'] = [
            'height' => 7.4,
            'heightUnit' => 'cm',
            'length' => 41.4,
            'lengthUnit' => 'cm',
            'width' => 14.6,
            'widthUnit' => 'cm',
            'weight' => 255,
            'weightUnit' => 'g',
        ];

        $product_data['packaging'] = [
            'unitsPerCarton' => '10',
            'unit' => 'g',
            'size' => '10',
        ];

        $product_data['name'] = [
            'en' => 'Sanita Paper Cups',
            'ar' => 'أكواب سانيتا الورقية',
        ];

        $product_data['shortDescription'] = [
            'en' => 'Sanita Disposable Paper Cups 100 Cups ',
        ];

        $product_data['keywords'] = [
            'en' => ['paper_cup'],
        ];
        $product_data['keyFeatures'] = [
            'en' => ['disposable paper cup'],
        ];
        $product_data['brand'] = [
            'en' => 'Sanita',
        ];
        $product_data['mediaUrls'] = [
            // 'https://m.media-amazon.com/images/I/91IWSrS2GxL._AC_SL1500_.jpg',
            // 'https://m.media-amazon.com/images/I/81wGmyBYI9L._AC_SL1500_.jpg',
            // 'https://m.media-amazon.com/images/I/81M+plaON+L._AC_SL1486_.jpg',
        ];

        return (new Tradeling)->createOrder($product_data);

        return ApiKey::where('name', 'tradeling')->first();
    }

    private function authenticate()
    {
        if ((new ApiKey)->isExpiredTradeling('tradeling')) {
            $response = (new Tradeling)->generateAPIToken();
            if ($response['status'] == 'success') {
                $data = $response['data'];
                $timestamp = Carbon::parse($data['expiresAt'])->toDateTimeString();
                $apiKey = ApiKey::where('name', 'tradeling')->first();
                if ($apiKey) {
                    $apiKey->token = $data['token'];
                    $apiKey->expires_at = $timestamp;
                    $apiKey->save();
                } else {
                    $apiKey = new ApiKey;
                    $apiKey->name = 'tradeling';
                    $apiKey->token = $data['token'];
                    $apiKey->expires_at = $timestamp;
                    $apiKey->save();
                }
            } else {
                dd('Failed to authenticate');
            }
        }
    }
}
