<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelZeroCategory extends Model
{
    protected $table = 'level_zero_categories';

    public function levelOneCategories()
    {
        return $this->hasMany(LevelOneCategory::class, 'level_zero_category_id', 'category_id');
    }
}
