<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;


class UserModel extends Authenticatable
{
    //
    use Notifiable, HasApiTokens, SoftDeletes;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    public $table = 'users';


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
        'key',
        'role',
        'email',
        'password'
    ];

    /**
     * The attributes that should be visible in arrays.
     *
     * @var array
     */
    protected $visible = [
        'id',
        'key',
        'name',
        'traveler',
        'role',
        'last_name',
        'middle_name',
        'email',
        'created_at',
    ];

    protected $hidden = [
        'password', 'remember_token'
    ];

    public function traveler()
    {
        return $this->hasOne('App\Data\Models\TravelerModel', 'user_id', 'key');
    }
}
