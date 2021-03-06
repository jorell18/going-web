<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ItineraryEntryModel extends Model
{
    //
    use SoftDeletes;


    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'itinerary_entries';


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
        'journal_id',
        'origin_id',
        'destination_id',
        'transportation_id',
        'sub_category_id',
        'start_time',
        'end_time',
        'activity_cost',
        'transportation_cost',
        'distance',
        'days',
        'nights',
        'is_checked_in',
        'title',
        'tag',
        'notes'
    ];

     /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'journal_id',
        'origin_id',
        'destination_id',
        'transportation_id',
        'sub_category_id',
        'start_time',
        'end_time',
        'activity_cost',
        'transportation_cost',
        'distance',
        'days',
        'nights',
        'is_checked_in',
        'title',
        'tag',
        'notes',
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
