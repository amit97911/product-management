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
        Schema::create('level_zero_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('listing_page_image_link', 255)->nullable();
            $table->integer('product_count')->nullable();
            $table->integer('level')->nullable();
            $table->timestamps();
            $table->softDeletesTz(column: 'deleted_at', precision: 0);
        });
        Schema::create('level_one_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('level_zero_category_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('listing_page_image_link', 255)->nullable();
            $table->integer('product_count')->nullable();
            $table->integer('level')->nullable();
            $table->timestamps();
            $table->softDeletesTz(column: 'deleted_at', precision: 0);
        });
        Schema::create('level_two_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('level_one_category_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('listing_page_image_link', 255)->nullable();
            $table->integer('product_count')->nullable();
            $table->integer('level')->nullable();
            $table->timestamps();
            $table->softDeletesTz(column: 'deleted_at', precision: 0);
        });
        Schema::create('level_three_categories', function (Blueprint $table) {
            $table->id();
            $table->string('category_id');
            $table->string('level_two_category_id')->nullable();
            $table->string('name', 255)->nullable();
            $table->string('slug', 255)->nullable();
            $table->string('listing_page_image_link', 255)->nullable();
            $table->integer('product_count')->nullable();
            $table->integer('level')->nullable();
            $table->timestamps();
            $table->softDeletesTz(column: 'deleted_at', precision: 0);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('level_zero_categories');
        Schema::dropIfExists('level_one_categories');
        Schema::dropIfExists('level_two_categories');
        Schema::dropIfExists('level_three_categories');
    }
};
