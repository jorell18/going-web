<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PlaceModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'places';


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
        'sub_category_id',
        'state_id',
        'address',
        'latitude',
        'longitude',
        'frequency',
        'average_cost'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'sub_category_id',
        'subCategory',
        'state_id',
        'state',
        'address',
        'latitude',
        'longitude',
        'frequency',
        'average_cost',
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

    public function state()
    {
        return $this->hasOne('App\Data\Models\StateModel','state_id');
    }
    
    public function subCategory()
    {
        return $this->hasOne('App\Data\Models\SubCategoryModel', 'sub_category_id');
    }
}
