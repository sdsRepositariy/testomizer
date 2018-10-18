<?php

namespace App\Models\Users;

use App\Models\Roles\Role as Role;
use App\Models\Users\Grade as Grade;
use App\Models\Communities\Community as Community;
use App\Models\Tasks\TaskItem as TaskItem;
use App\Models\Tasks\TaskFolder as TaskFolder;
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
     * Get the student of a parent.
    */
    public function student()
    {
        return $this->belongsTo(__CLASS__, 'user_id');
    }

    /**
     * Get the tasks list for the user.
     */
    public function taskItems()
    {
        return $this->hasMany(TaskItem::class);
    }

    /**
     * Get the task folders for the user.
     */
    public function taskFolders()
    {
        return $this->hasMany(TaskFolder::class);
    }

    /**------------Model queries------------*/

    /**
     * Get students.
     *
     * @param string $sort
     * @param string $order
     * @param array $filters
     * @param array $gradesId
     * @param string $search
     *
     * @return Illuminate\Database\Query\Builder
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
                } elseif ($key == 'status' && $value == 'deleted') {
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

        return $query;
    }

    /**
     * Get parents.
     *
     * @param string $sort
     * @param string $order
     * @param array $filters
     * @param array $gradesId
     * @param string $search
     *
     * @return Illuminate\Database\Query\Builder
    */
    public function getParents($sort, $order, $filter, $gradesId, $search)
    {
        $userGroupId = \DB::table('user_groups')->where('group', 'students')->value('id');

        $query = \DB::table('users as students')
            ->select(
                'levels.number as level',
                'streams.name as stream',
                'students.id as student_id',
                'students.first_name as student_first_name',
                'students.middle_name as student_middle_name',
                'students.last_name as student_last_name',
                'parents.*'
            )
            ->join('grade_user', function ($join) use ($gradesId) {
                $join->on('students.id', '=', 'grade_user.user_id')
                ->whereIn('grade_user.grade_id', $gradesId);
            })
            ->join('grades', 'grade_user.grade_id', '=', 'grades.id')
            ->join('levels', 'grades.level_id', '=', 'levels.id')
            ->join('streams', 'grades.stream_id', '=', 'streams.id')
            ->leftJoin('users as parents', 'parents.user_id', '=', 'students.id');
            
        $query->whereNull('students.deleted_at');

        $query->where('students.user_group_id', $userGroupId);

        foreach ($filter as $key => $value) {
            if (!empty($value)) {
                $query->where('students.'.$key.'_'.'id', $value);
            }
        }

        if (!empty($search)) {
            $query->where('students.last_name', 'like', $search.'%')->orWhere('parents.last_name', 'like', $search.'%');
        }

        $query->orderBy($sort, $order);

        return $query;
    }

    /**
     * Get teachers.
     *
     * @param string $sort
     * @param string $order
     * @param array $filters
     * @param string $search
     *
     * @return Illuminate\Database\Query\Builder
    */
    public function getTeachers($sort, $order, $filter, $search)
    {
        $userGroupId = \DB::table('user_groups')->where('group', 'teachers')->value('id');

        $query = \DB::table('users')
            ->select(
                'roles.role',
                'users.*'
            )
            ->join('roles', 'users.role_id', '=', 'roles.id');
            
        $query->where('users.user_group_id', $userGroupId);

        foreach ($filter as $key => $value) {
            if (!empty($value)) {
                if ($key == 'status' && $value == 'active') {
                    $query->whereNull('users.deleted_at');
                } elseif ($key == 'status' && $value == 'deleted') {
                    $query->whereNotNull('users.deleted_at');
                } else {
                    $query->where('users.'.$key.'_'.'id', $value);
                }
            }
        }

        if (!empty($search)) {
            $query->where('last_name', 'like', $search.'%');
        }

        $query->orderBy($sort, $order);

        return $query;
    }
}
