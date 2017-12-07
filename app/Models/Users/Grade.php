<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User as User;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Level as Level;
use App\Models\Users\Period as Period;

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

    /**
     * The period that belong to the grade.
    */
    public function period()
    {
        return $this->belongsTo(Period::class);
    }

    /**
     * Get grades id.
     *
     * @param string $community
     * @param array $filterGrade
     *
     * @return array
    */
    public function getGradesId($community, $filterGrade)
    {
        $gradeId = array();

        $gradeQuery = \DB::table('grades')->where('community_id', $community);

        foreach ($filterGrade as $key => $value) {
            if (!empty($value)) {
                $gradeQuery->where($key.'_'.'id', $value);
            }
        }

        $grades = $gradeQuery->get();

        foreach ($grades as $key => $value) {
            $gradeId[] = $value->id;
        }

        return $gradeId;
    }
}
