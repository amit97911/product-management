<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelTwoCategory extends Model
{
    use SoftDeletes;

    protected $table = 'level_two_categories';

    public function levelThreeCategories()
    {
        return $this->hasMany(LevelThreeCategory::class, 'level_two_category_id', 'category_id');
    }

    public function levelOneCategory()
    {
        return $this->belongsTo(LevelOneCategory::class, 'level_one_category_id', 'category_id');
    }
}
