<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create(table: 'api_keys', callback: function (Blueprint $table): void {
            $table->id();
            $table->string(column: 'name')->unique();
            $table->longText(column: 'token');
            $table->timestamp(column: 'expires_at')->nullable();
            $table->timestamp(column: 'last_used_at')->nullable();
            $table->enum(column: 'status', allowed: ['active', 'inactive', 'revoked'])->default(value: 'active');
            $table->timestamps();
            $table->softDeletesTz(column: 'deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists(table: 'api_keys');
    }
};
