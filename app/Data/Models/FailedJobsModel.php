<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;

class FailedJobsModel extends Model
{
    //

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'failed_jobs';


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
    public $timestamps = false;

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
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'connection',
        'queue',
        'payload',
        'exception',
        'failed_at'
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
