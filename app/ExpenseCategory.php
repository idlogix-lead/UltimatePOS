<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ExpenseCategory extends Model
{
    use SoftDeletes;
    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    public function sub_categories()
    {
        return $this->hasMany(\App\ExpenseCategory::class, 'parent_id');
    }
    public static function GetList($business_id)
    {
        $all_categories = ExpenseCategory::where('business_id', $business_id)
                            // ->whereNull("parent_id")
                            ->whereNull("deleted_at")
                            ->select(["id",'name',"parent_id"])
                            ->get()
                            ->toArray();

        if (empty($all_categories)) {
            return [];
        }
        $categories = [];
        $sub_categories = [];

        foreach ($all_categories as $category) {
            if ($category['parent_id'] == "") {
                $categories[] = $category;
            } else {
                $sub_categories[] = $category;
            }
        }

        $sub_cat_by_parent = [];
        if (! empty($sub_categories)) {
            foreach ($sub_categories as $sub_category) {
                if (empty($sub_cat_by_parent[$sub_category['parent_id']])) {
                    $sub_cat_by_parent[$sub_category['parent_id']] = [];
                }

                $sub_cat_by_parent[$sub_category['parent_id']][] = $sub_category;
            }
        }

        foreach ($categories as $key => $value) {
            if (! empty($sub_cat_by_parent[$value['id']])) {
                $categories[$key]['sub_categories'] = $sub_cat_by_parent[$value['id']];
            }
        }

        return $categories;
    }
    /**
     * Scope a query to only include main categories.
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function scopeOnlyParent($query)
    {
        return $query->whereNull('parent_id');
    }
}
