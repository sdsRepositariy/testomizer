<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User as User;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Level as Level;

class Grade extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['level_id', 'stream_id', 'period_id'];

    /**------------Model relationships------------*/

    /**
     * The users that belong to the grade.
    */
    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    /**
     * The stream that belong to the grade.
    */
    public function stream()
    {
        return $this->belongsTo(Stream::class);
    }

    /**
     * The level that belong to the grade.
    */
    public function level()
    {
        return $this->belongsTo(Level::class);
    }
}
