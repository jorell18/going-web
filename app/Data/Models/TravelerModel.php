<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class TravelerModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'travelers';


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
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'user_id',
        'email',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'baseCurrency',
        'picture'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'user_id',
        'user',
        'email',
        'first_name',
        'last_name',
        'middle_name',
        'birthdate',
        'baseCurrency',
        'picture',
        'journals',
        'created_at',
        'updated_at'
    ];


    public function journals()
    {
        return $this->hasMany('App\Data\Models\JournalModel', 'traveler_id', 'id');
    }

    // public function itineraries()
    // {
    //     return $this->hasMany('App\Data\Models\ItineraryModel', 'traveler_id', 'id');
    // }

    public function user()
    {
        return $this->belongsTo('App\Data\Models\UserModel', 'user_id', 'key');
    }
}
