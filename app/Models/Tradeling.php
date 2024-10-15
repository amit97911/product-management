<?php

namespace App\Models;

use Carbon\Carbon;
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

                return ['status' => 'success', 'message' => 'Token generated successfully'];
            } else {
                $error = $response->body();
                Log::critical('Tradeling api call did not return 200 ');
                Log::critical($error);

                return ['status' => 'error', 'message' => 'Token generated successfully'];
            }
        } catch (RequestException $e) {
            Log::critical('Tradeling api call catch block ');
            Log::critical($e->getMessage());

            return ['error' => 'Failed to generate API token'];
        }
    }
}
