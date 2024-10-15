<?php

namespace App\Observers;

use App\Models\ApiKey;
use Illuminate\Support\Facades\Crypt;

class TradelingApiKeyObserver
{
    /**
     * Handle the ApiKey "created" event.
     */
    public function created(ApiKey $apiKey): void
    {
        //
    }

    /**
     * Handle the ApiKey "updated" event.
     */
    public function updated(ApiKey $apiKey): void
    {
        //
    }

    /**
     * Handle the ApiKey "deleted" event.
     */
    public function deleted(ApiKey $apiKey): void
    {
        //
    }

    /**
     * Handle the ApiKey "restored" event.
     */
    public function restored(ApiKey $apiKey): void
    {
        //
    }

    /**
     * Handle the ApiKey "force deleted" event.
     */
    public function forceDeleted(ApiKey $apiKey): void
    {
        //
    }

    /**
     *Auto update last_used_at
     */
    public function retrieved(ApiKey $apiKey): void
    {
        $apiKey->update(['last_used_at' => now()]);
        $apiKey->token = Crypt::decrypt($apiKey->token);
    }

    /**
     * Auto Encrypt the key before update
     */
    public function updating(ApiKey $apiKey): void
    {
        if ($apiKey->isDirty('token') || $apiKey->getOriginal('token') === null) {
            $apiKey->token = Crypt::encrypt($apiKey->token);
        }

    }

    /**
     * Auto Encrypt the key before create
     */
    public function creating(ApiKey $apiKey): void
    {
        $apiKey->token = Crypt::encrypt($apiKey->token);
    }
}
