<?php

namespace App\Http\Controllers;

use App\Models\LevelOneCategory;
use App\Models\LevelThreeCategory;
use App\Models\LevelTwoCategory;
use App\Models\LevelZeroCategory;
use App\Models\Tradeling;

class CategoryApiController extends Controller
{
    public function fetchCategories()
    {
        $now = now();
        $response = (new Tradeling)->fetchCategories();
        $level_zero_categories = $level_one_categories = $level_two_categories = $level_three_categories = [];
        if ($response['status'] == 'success') {
            $categories = $response['data'];
            foreach ($categories as $category0) {
                $level_zero_categories[] = [
                    'category_id' => $category0['id'],
                    'name' => $category0['name'],
                    'level' => $category0['level'],
                    'slug' => $category0['slug'],
                    'listing_page_image_link' => isset($category1['listingPageImageLink']) ? $category1['listingPageImageLink'] : null,
                    'product_count' => $category0['productCount'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
                foreach ($category0['childrenTree'] as $category1) {
                    $level_one_categories[] = [
                        'category_id' => $category1['id'],
                        'level_zero_category_id' => $category1['parentId'],
                        'name' => $category1['name'],
                        'level' => $category1['level'],
                        'slug' => $category1['slug'],
                        'listing_page_image_link' => isset($category1['listingPageImageLink']) ? $category1['listingPageImageLink'] : null,
                        'product_count' => $category1['productCount'],
                        'created_at' => $now,
                        'updated_at' => $now,
                    ];
                    foreach ($category1['childrenTree'] as $category2) {
                        $level_two_categories[] = [
                            'category_id' => $category2['id'],
                            'level_one_category_id' => $category2['parentId'],
                            'name' => $category2['name'],
                            'level' => $category2['level'],
                            'slug' => $category2['slug'],
                            'listing_page_image_link' => isset($category2['listingPageImageLink']) ? $category2['listingPageImageLink'] : null,
                            'product_count' => $category2['productCount'],
                            'created_at' => $now,
                            'updated_at' => $now,
                        ];
                        foreach ($category2['childrenTree'] as $category3) {
                            $level_three_categories[] = [
                                'category_id' => $category3['id'],
                                'level_two_category_id' => $category3['parentId'],
                                'name' => $category3['name'],
                                'level' => $category3['level'],
                                'slug' => $category3['slug'],
                                'listing_page_image_link' => isset($category3['listingPageImageLink']) ? $category3['listingPageImageLink'] : null,
                                'product_count' => $category3['productCount'],
                                'created_at' => $now,
                                'updated_at' => $now,
                            ];
                        }
                    }
                }
            }
            LevelZeroCategory::insert($level_zero_categories);
            LevelOneCategory::insert($level_one_categories);
            LevelTwoCategory::insert($level_two_categories);
            LevelThreeCategory::insert($level_three_categories);
        }
    }
}
