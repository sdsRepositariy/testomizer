<?php

namespace App\Http\Controllers\Users\Students;

use App\Models\Roles\Role as Role;
use App\Models\Users\User as User;
use App\Models\Communities\Community as Community;
use App\Models\Users\Level as Level;
use App\Models\Users\Stream as Stream;
use App\Models\Users\UserGroup as Usergroup;
use App\Models\Users\Period as Period;
use App\Models\Users\Grade as Grade;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ValidateStudentForm as ValidateStudentForm;

class UserController extends Controller
{
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if (\Gate::denies('create', 'user-respondent')) {
            abort(403);
        }

        //Get selected period or default value
        $filter['period'] = session('filter_grade.period');

        if (!isset($filter['period'])) {
            $period = new Period();
            $filter['period'] = $period->getCurrentPeriodId();
        }

        //Get community id
        $filter['community'] = session('filter_community');

        if (!isset($filter['community'])) {
            $filter['community'] = \Auth::user()->community_id;
        }
    
        $filter['level'] = session('filter_grade.level');
    
        $filter['stream'] = session('filter_grade.stream');

        //Get url of the user list
        if (session('user_list') == null) {
            $urlUserList = url('usergroup/students', 'list');
        } else {
            $urlUserList = session('user_list');
        }

        return view('admin.users.students.create', [
            'user' => new User(),
            'filter' => $filter,
            'levels' => Level::all(),
            'streams' => Stream::all(),
            'periods' => Period::all(),
            'communities' => Community::all(),
            'path' => 'usergroup/students/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  ValidateStudentForm $request
     * @return \Illuminate\Http\Response
     */
    public function store(ValidateStudentForm $request)
    {
        $input = $request->all();

        //Complete missed data
        $input['login'] = $input['community_id'].'_'.str_slug($input['last_name']);
        $input['password'] = str_random(6);
        $input['role_id'] = Role::where('role', 'respondent')->first()->id;
        $input['user_group_id'] = Usergroup::where('group', 'students')->first()->id;

        //Store user data
        $user = User::create($input);
   
        //Check if grade exists in the given community
        $grade = Grade::where([
            ['level_id', $input['level_id']],
            ['period_id', $input['period_id']],
            ['stream_id', $input['stream_id']],
            ['community_id', $input['community_id']],
        ])->first();

        //If grade doesnt exists then create missed grade
        if ($grade == null) {
            $grade = Grade::create($input);
        }
            
        //Insert the record to the intermediate table.
        $user->grades()->attach($grade->id);

        $message = [
                'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_created')
            ];

        return back()->with($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function show($user)
    {
        if (\Gate::denies('view', 'user-respondent')) {
            abort(403);
        }
        
        //Get selected period id or period for last users grade
        $filter['period'] = session('filter_grade.period');

        if (!isset($filter['period'])) {
            $filter['period'] = $user->grades()->get()->last()->period_id;
        }

        //Get community id
        $filter['community'] = $user->community_id;

        //Get grade data
        $userGrade = $user->grades()->where('period_id', $filter['period'])->first();
        
        $filter['level'] = $userGrade->level_id;

        $filter['stream'] = $userGrade->stream_id;

        //Levels, streams, periods should be related to certain community
        $selectedCommunity = Community::find($filter['community']);

        //The community may have diferent quantity of levels and streams
        //depending on a period. So to get right lists of levels and
        //streams we need to select it for certain period and select items
        //with unique id's.
        $streams = $selectedCommunity->streams()->where('period_id', $filter['period'])->orderBy('name', 'asc')->get()->unique('id');

        $levels = $selectedCommunity->levels()->where('period_id', $filter['period'])->orderBy('number', 'asc')->get()->unique('id');

        $periods = $selectedCommunity->periods()->get()->unique('id');

        //Get url of the user list
        if (session('user_list') == null) {
            $urlUserList = url('usergroup/students', 'list');
        } else {
            $urlUserList = session('user_list');
        }

        return view('admin.users.students.create', [
            'user' => $user,
            'filter' => $filter,
            'levels' => $levels,
            'streams' => $streams,
            'periods' => $periods,
            'communities' => array($selectedCommunity),
            'path' => 'usergroup/students/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function edit($user)
    {
        if (\Gate::denies('update', 'user-respondent')) {
            abort(403);
        }
        
        //Get selected period id or period for last users grade
        $filter['period'] = session('filter_grade.period');

        if (!isset($filter['period'])) {
            $filter['period'] = $user->grades()->get()->last()->period_id;
        }

        //Get community id
        $filter['community'] = $user->community_id;

        //Get grade data
        $userGrade = $user->grades()->where('period_id', $filter['period'])->first();

        $filter['level'] = $userGrade->level_id;

        $filter['stream'] = $userGrade->stream_id;

        //Levels, streams, periods should be related to certain community
        $selectedCommunity = Community::find($filter['community']);

        //The community may have diferent quantity of levels and streams
        //depending on a period. So to get right lists of levels and
        //streams we need to select it for certain period and select items
        //with unique id's.
        $streams = $selectedCommunity->streams()->where('period_id', $filter['period'])->orderBy('name', 'asc')->get()->unique('id');

        $levels = $selectedCommunity->levels()->where('period_id', $filter['period'])->orderBy('number', 'asc')->get()->unique('id');

        $periods = $selectedCommunity->periods()->get()->unique('id');

        //Get url of the user list
        if (session('user_list') == null) {
            $urlUserList = url('usergroup/students', 'list');
        } else {
            $urlUserList = session('user_list');
        }

        return view('admin.users.students.create', [
            'user' => $user,
            'filter' => $filter,
            'levels' => $levels,
            'streams' => $streams,
            'periods' => $periods,
            'communities' => array($selectedCommunity),
            'path' => 'usergroup/students/user',
            'urlUserList' => $urlUserList,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  ValidateStudentForm $request
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function update(ValidateStudentForm $request, $user)
    {
        $input = $request->all();
        
        //Update user table
        $user->update($input);

        //Get new grade id
        $newGradeId = Grade::where([
            ['level_id', $input['level_id']],
            ['period_id', $input['period_id']],
            ['stream_id', $input['stream_id']],
            ['community_id', $input['community_id']],
        ])->first()->id;

        //Get old grade id
        $oldGradeId = $user->grades()->where('period_id', $input['period_id'])->first()->id;

        //Update grade-user table
        $user->grades()->updateExistingPivot($oldGradeId, ['grade_id' => $newGradeId]);

        $message = [
                'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_updated')
            ];

        //Get url of the user list
        if (session('user_list') == null) {
            $urlUserList = url('usergroup/students', 'list');
        } else {
            $urlUserList = session('user_list');
        }

        return redirect($urlUserList)->with($message);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
     */
    public function destroy($user)
    {
        if (\Gate::denies('delete', 'user-respondent')) {
            abort(403);
        }

        $user->delete();

        if ($user->parent != null) {
            $parent = $user->parent->delete();
        }

        $message = [
            'flash_message'=> \Lang::get('admin/users.the_user').'&nbsp;'
                .$user->last_name.'&nbsp;'.$user->first_name
                .'&nbsp;'.\Lang::get('admin/users.successfully_removed')
        ];

        return back()->with($message);
    }

    /**
     * Generate new password for the user.
     *
     * @param  User $user
     * @return \Illuminate\Http\Response
    */
    public function changePassword($user)
    {
        if (\Gate::denies('create', 'user-respondent')) {
            return false;
        }

        $user->password = str_random(6);

        $user->save();

        $message = [
                'flash_message'=> \Lang::get('admin/users.new_password').'&nbsp;'
                .$user->password.'&nbsp;'.\Lang::get('admin/users.successfully_created')
            ];

        return back()->with($message);
    }
}
