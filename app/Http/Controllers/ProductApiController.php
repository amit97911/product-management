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

        return (new LevelZeroCategory)->with('levelOneCategories.levelTwoCategories.levelThreeCategories')->get();

        return (new LevelThreeCategory)->with('levelTwoCategory.levelOneCategory.levelZeroCategory')->get();

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
