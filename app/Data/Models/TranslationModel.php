<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class TranslationModel extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'translations';


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
        'table_name',
        'column_name',
        'foreign_key',
        'locale',
        'value'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'table_name',
        'column_name',
        'foreign_key',
        'locale',
        'value',
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
}
