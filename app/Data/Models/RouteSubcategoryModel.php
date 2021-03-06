<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RouteSubcategoryModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'route_subcategory';


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
        'route_id',
        'sub_category_id'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'route_id',
        'route',
        'sub_category_id',
        'subcategory',
        'created_at',
        'updated_at'
    ];

    public function route()
    {
        return $this->belongsTo('App/Data/Models/RouteModel', 'route_id');
    }

    public function subcategory()
    {
        return $this->hasOne('App/Data/Models/SubCategoryModel', 'id', 'sub_category_id');
    }
}
