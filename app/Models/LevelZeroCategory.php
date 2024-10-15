<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelZeroCategory extends Model
{
    use SoftDeletes;

    protected $table = 'level_zero_categories';

    public function levelOneCategories()
    {
        return $this->hasMany(LevelOneCategory::class, 'level_zero_category_id', 'category_id');
    }
}
