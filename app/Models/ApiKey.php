<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApiKey extends Model
{
    use SoftDeletes;

    protected $fillable = ['name', 'token', 'expires_at', 'last_used_at', 'status'];

    public function isExpiredTradeling($name)
    {
        $apiKey = self::where('name', $name)->first();
        if (! $apiKey) {
            return true;
        }

        return now()->greaterThan($apiKey->expires_at);
    }
}
