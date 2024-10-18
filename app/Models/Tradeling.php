<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class Tradeling extends Model
{
    public function generateAPIToken()
    {
        try {
            $headers = [
                'accept' => 'application/json, text/plain, */*',
                'x-store-id' => 'tcom-ae',
                'Content-Type' => 'application/json',
            ];
            // $url = config('tradeling.tradeling_test_url').'/api/module-account/v3/auth/api-key';
            // if (config('app.env') == 'production') {
            $url = config('tradeling.tradeling_prod_url').'/api/module-account/v3/auth/api-key';
            // }
            $response = Http::withHeaders($headers)->post($url, [
                'apiKey' => config('tradeling.tradeling_key'),
            ]);
            if ($response->successful()) {
                $data = $response->json();

                return ['status' => 'success', 'message' => 'Token generated successfully', 'data' => $data];
            } else {
                $error = $response->body();
                Log::critical('Tradeling api call did not return 200 ');
                Log::critical($error);

                return ['status' => 'error', 'message' => 'Failed to generate API token', 'data' => null];
            }
        } catch (RequestException $e) {
            Log::critical('Tradeling::generateAPIToken()  catch block ');
            Log::critical($e->getMessage());

            return ['status' => 'error', 'message' => 'Exception: Failed to generate API token'];
        }
    }

    public function fetchCategories()
    {
        try {
            $headers = [
                'accept' => 'application/json, text/plain, */*',
                'x-store-id' => 'tcom-ae',
                'Content-Type' => 'application/json',
            ];
            // $url = config('tradeling.tradeling_test_url').'/api/module-catalog-search/v3-get-category-tree?maxLevel=3';
            // if (config('app.env') == 'production') {
            $url = config('tradeling.tradeling_prod_url').'/api/module-catalog-search/v3-get-category-tree?maxLevel=3';
            // }
            $response = Http::withHeaders($headers)->get($url);
            if ($response->successful()) {
                $data = $response->json();

                return ['status' => 'success', 'message' => 'Category fetch successful', 'data' => $data];
            } else {
                $error = $response->body();
                Log::critical('Tradeling api call did not return 200 ');
                Log::critical($error);

                return ['status' => 'error', 'message' => 'Category fetch failed', 'data' => null];
            }
        } catch (RequestException $e) {
            Log::critical('Tradeling api call catch block ');
            Log::critical($e->getMessage());

            return ['status' => 'error', 'message' => 'Exception: Category fetch failed'];
        }
    }

    public function createOrder($product_data = [])
    {
        if (empty($product_data)) {
            return ['status' => 'error', 'message' => 'Product data is required'];
        }
        $jwt_token = ApiKey::select('token')->where('name', 'tradeling')->first();
        $headers = [
            'x-jwt-token' => $jwt_token->token,
            'Content-Type' => 'application/json',
        ];
        $body = [
            [
                'dimensions' => $product_data['dimensions'],
                'packaging' => $product_data['packaging'],
                'stockQty' => $product_data['stockQty'],
                'unit' => $product_data['unit'],
                'sku' => $product_data['sku'],
                'mediaUrls' => $product_data['mediaUrls'],
                'keywords' => $product_data['keywords'],
                'keyFeatures' => $product_data['keyFeatures'],
                'attributes' => [
                    'dangerousGoods' => 'No',
                    'brand' => $product_data['brand'],
                    'testingRegression' => 'test',
                ],
                'name' => $product_data['name'],
                'selectedCategoryMoq' => 1,
                'categoryId' => $product_data['categoryId'],
                'offers' => [
                    [
                        'delivery' => [
                            'leadTimeValue' => 10,
                            'leadTimeUnit' => 'days',
                        ],
                        'market' => [
                            'label' => 'UAE Market (GULF)',
                            'code' => 'AE',
                            'currency' => 'AED',
                            'tiers' => [
                                [
                                    'minQty' => 1,
                                    'retailPrice' => null,
                                    'tierCode' => 'TIERS-1',
                                    'price' => $product_data['price'],
                                ],
                            ],
                        ],
                    ],
                ],
                'longDescription' => new \stdClass,
                'transportationMode' => 'regular',
                'additionalAttributes' => [new \stdClass],
                'isBuyNow' => true,
                'isInStock' => true,
                'isReadyToShip' => true,
                'shortDescription' => $product_data['shortDescription'],
                'offerPrivateLabelOption' => 'no',
                'tags' => [],
                'type' => 'simple',
                'hasPrivateLabel' => false,
            ],
        ];

        // dd($body);
        // Send the request
        // $url = config('tradeling.tradeling_test_url').'/api/module-catalog-pim/v3/products';
        // if (config('app.env') == 'production') {
        $url = config('tradeling.tradeling_prod_url').'/api/module-catalog-pim/v3/products';
        // }
        $response = Http::withHeaders($headers)->post($url, $body);
        // dd($response);
        // Handle the response
        $json = $response->json();
        $body = $response->body();
        dd($json, $body, $body, $response);
    }
}
