<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class CategoriesModel extends Model
{


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'categories';


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
        'parent_id',
        'order',
        'name',
        'slug'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'parent_id',
        'order',
        'name',
        'slug',
        'created_at',
        'updated_at'
    ];
}
