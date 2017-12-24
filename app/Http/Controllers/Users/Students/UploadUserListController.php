<?php

namespace App\Http\Controllers\Users\Students;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\Level as Level;
use App\Models\Users\Stream as Stream;
use App\Models\Users\Period as Period;
use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Users\Grade as Grade;
use App\Models\Users\UserGroup as Usergroup;
use App\Models\Communities\Community as Community;
use App\Http\Requests\ValidateStudentFile as ValidateStudentFile;
use Carbon\Carbon;

class UploadUserListController extends Controller
{
    /**
     * Show the form for upload.
     *
     * @return \Illuminate\Http\Response
    */
    public function upload()
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

        return view('admin.users.students.upload', [
            'filter' => $filter,
            'periods' => Period::all(),
            'path' => 'usergroup/students',
            'urlUserList' => url('usergroup/students', 'list'),
            'communities' => Community::all(),
        ]);
    }

    /**
     * Upload the the user list.
     *
     * @param  ValidateStudentFile  $request
     * @return Response
     */
    public function store(ValidateStudentFile $request)
    {
        $period_id = $request->input('period_id');

        $community_id = $request->input('community_id');

        $path = $request->file('file_students')->store('users/'.$request->user()->id);

        $reader = \Excel::selectSheetsByIndex(0)->load('storage/app/'.$path);

        \Storage::delete($path);
        
        $list = $reader->select(array('level', 'stream', 'first_name', 'last_name', 'middle_name', 'birthday'))->get()->toArray();

        //Validate file by row
        $errors = $this->validateRow($list, $community_id, $period_id);

        if ($errors->all()) {
            return redirect('usergroup/students/upload')->withErrors($errors)->withInput();
        }

        //Store the student list in storage.
        foreach ($list as $row) {
            //Complete missed data
            $row['level_id'] = Level::where('number', $row['level'])->first()->id;
            $row['stream_id'] = Stream::where('name', strtoupper($row['stream']))->first()->id;
            $row['period_id'] = $period_id;
            $row['community_id'] = $community_id;
            $row['login'] = $community_id.'_'.str_slug($row['last_name']);
            $row['password'] = str_random(6);
            $row['role_id'] = Role::where('role', 'respondent')->first()->id;
            $row['user_group_id'] = Usergroup::where('group', 'students')->first()->id;
            $row['birthday'] = Carbon::parse($row['birthday'])->toDateString();

            //Check if user exists and if not create new
            $user = User::where([
                ['first_name', $row['first_name']],
                ['middle_name', $row['middle_name']],
                ['last_name', $row['last_name']],
                ['community_id', $row['community_id']],
                ['birthday', $row['birthday']]
             ])->first();

            //Store user data
            if ($user == null) {
                $user = User::create($row);
            }

            //Check if grade exists in the given community
            $grade = Grade::where([
                ['level_id', $row['level_id']],
                ['period_id', $row['period_id']],
                ['stream_id', $row['stream_id']],
                ['community_id', $row['community_id']],
            ])->first();

            //If grade doesnt exists then create missed grade
            if ($grade == null) {
                $grade = Grade::create($row);
            }
                
            //Insert the record to the intermediate table.
            $user->grades()->attach($grade->id);
        }

        $message = ['flash_message'=> \Lang::get('admin/users.successfully_uploaded')];

        return back()->with($message);
    }

    /**
     * Validate row from uploaded file.
     *
     * @param  array  $list
     * @param  int  $community_id
     * @param  int $period_id
     * @return Illuminate\Support\MessageBag
     */
    protected function validateRow($list, $community_id, $period_id)
    {
        $rowNumber = 2; //The first row is the header
        $temp = array();

        foreach ($list as $row) {
            $validator = \Validator::make($row, [
                'first_name' => [
                        'required',
                        "regex:/^[\pL\pM\pPd]+$/u",
                        'max:255',
                ],
                'middle_name' => [
                        'required',
                        "regex:/^[\pL\pM\pPd]+$/u",
                        'max:255',
                ],
                'last_name' => [
                        'required',
                        "regex:/^[\pL\pM\pPd]+$/u",
                        'max:255',
                ],
                'level' => 'required|exists:levels,number',
                'stream' => 'required|exists:streams,name',
                'email' => 'nullable|email|max:255|unique:users,email',
                'phone_number' => 'nullable|string|max:45|unique:users,phone_number',
                'birthday' => 'required|date_format:"d.m.Y"',
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('row', \Lang::get('admin/users.row').$rowNumber);
                break;
            }

            //Additional check to avoid user duplicate in the list
            $validator->after(function ($validator) use ($row, $temp, $rowNumber) {
                if (in_array($row, $temp)) {
                    $validator->errors()->add('student_error', \Lang::get('admin/users.user_exists'));
                }
            });
        
            if ($validator->fails()) {
                $validator->errors()->add('row', \Lang::get('admin/users.row').$rowNumber);
                break;
            }

            $temp[$rowNumber] = $row;

            ++$rowNumber;
        }
        unset($temp);

        return $validator->errors();
    }
}
