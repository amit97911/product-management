<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LevelThreeCategory extends Model
{
    use SoftDeletes;

    protected $table = 'level_three_categories';

    public function levelTwoCategory()
    {
        return $this->belongsTo(LevelTwoCategory::class, 'level_two_category_id', 'category_id');
    }
}
