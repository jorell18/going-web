<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CategoryModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'category';


    /**
     * The primary key of the table.
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * Indicates if there are timestamps.
     *
     * @var bool
     */
    public $timestamps = true;

    /**
     * Indicates if the ids are auto-incrementing.
     *
     * @var bool
     */
    public $incrementing = true;

     /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'subCategories',
        'created_at',
        'updated_at'
    ];

    public function subCategories()
    {
        return $this->hasMany('App\Data\Models\SubCategoryModel', 'category_id', 'id');
    }
}
