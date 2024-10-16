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
            // $url = config('tradeling.tradeling_test_url').'/api/module-account/v3/auth/api-key';
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
}
