<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelOneCategory extends Model
{
    use SoftDeletes;

    protected $table = 'level_one_categories';

    public function levelTwoCategories()
    {
        return $this->hasMany(LevelTwoCategory::class, 'level_one_category_id', 'category_id');
    }

    public function levelZeroCategory()
    {
        return $this->belongsTo(LevelZeroCategory::class, 'level_zero_category_id', 'category_id');
    }
}
