<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItineraryModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'itineraries';


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
        'traveler_id',
        'sate_origin_id',
        'stateOrigin',
        'state_destination_id',
        'stateDestination',
        'total_cost',
        'title',
        'start_date',
        'end_date',
        'published',
        'number_of_days',
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'traveler_id',
        'traveler',
        'sate_origin_id',
        'total_cost',
        'title',
        'start_date',
        'end_date',
        'published',
        'number_of_days',
        'created_at',
        'updated_at'
    ];


    //RELATIONSHIP
    /**
     * Get encoder details.
     */
    // public function traveler()
    // {
    //     return $this->belongsTo('App\Data\Models\TravelerModel', 'traveler_id', 'id');
    // }
}
