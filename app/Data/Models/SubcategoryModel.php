<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategoryModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'sub_category';


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
        'name',
        'category_id',
        'frequency'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'name',
        'category_id',
        'category',
        'frequency',
        'country_id',
        'created_at',
        'updated_at'
    ];


    //RELATIONSHIP
    /**
     * Get encoder details.
     */
    // public function encoder()
    // {
    //     return $this->hasOne('App\Data\Models\UserModel', 'id', 'encoder_id');
    // }
    public function category()
    {
        return $this->belongsTo('App\Data\Models\CategoryModel', 'category_id', 'id');
    }
}
