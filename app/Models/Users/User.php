<?php

namespace App\Models\Users;

use App\Models\Roles\Role as Role;
use App\Models\Users\Grade as Grade;
use App\Models\Communities\Community as Community;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{
    use Notifiable;

    use SoftDeletes;

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = ['deleted_at'];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['community_id', 'role_id', 'first_name', 'middle_name', 'last_name', 'login', 'password', 'birthday', 'email', 'phone_number', 'user_group_id', 'user_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * Check if given role is Superadmin.
     * The superadmin role has not parents
     * so we will check if the role has a parent
     *
     * @return bool
    */
    public function isSuperadmin()
    {
        return $this->role->role_id === null;
    }

   
    /**------------Model relationships------------*/
    
    
    //Get the role associated with the user.
    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    /**
     * Get the user group that owns the user.
     */
    public function userGroup()
    {
        return $this->belongsTo(UserGroup::class);
    }

    //Get the community associated with the user.
    public function community()
    {
        return $this->belongsTo(Community::class);
    }

    //Get the grade associated with the user.
    public function grades()
    {
        return $this->belongsToMany(Grade::class);
    }

    /**
     * Get the parent of a student.
    */
    public function parent()
    {
        return $this->hasOne(__CLASS__);
    }

    /**
     * Get students.
     *
     * @param string $sort
     * @param string $order
     * @param array $filters
     * @param array $gradesId
     * @param string $search
     *
     * @return array
    */
    public function getStudents($sort, $order, $filter, $gradesId, $search)
    {
        $userGroupId = \DB::table('user_groups')->where('group', 'students')->value('id');

        $query = \DB::table('users')
            ->join('grade_user', function ($join) use ($gradesId) {
                $join->on('users.id', '=', 'grade_user.user_id')
                ->whereIn('grade_user.grade_id', $gradesId);
            })
            ->join('grades', 'grade_user.grade_id', '=', 'grades.id')
            ->join('levels', 'grades.level_id', '=', 'levels.id')
            ->join('streams', 'grades.stream_id', '=', 'streams.id')
            ->select('levels.number as level', 'users.*', 'streams.name as stream');

        $query->where('users.user_group_id', $userGroupId);

        foreach ($filter as $key => $value) {
            if (!empty($value)) {
                if ($key == 'status' && $value == 'active') {
                    $query->whereNull('users.deleted_at');
                } else if ($key == 'status' && $value == 'deleted') {
                    $query->whereNotNull('users.deleted_at');
                } else {
                    $query->where('users.'.$key.'_'.'id', $value);
                }
            }
        }

        if (!empty($search)) {
            $query->where('users.last_name', 'like', $search.'%')->orWhere('users.email', 'like', $search.'%');
        }

        $query->orderBy($sort, $order);

        return $query->paginate(7);
    }
}
