<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LevelThreeCategory extends Model
{
    protected $table = 'level_three_categories';

    public function levelTwoCategory()
    {
        return $this->belongsTo(LevelTwoCategory::class, 'level_two_category_id', 'category_id');
    }
}
