<?php

namespace App\Http\Controllers\Users\Teachers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Users\User as User;
use App\Models\Roles\Role as Role;
use App\Models\Users\UserGroup as Usergroup;
use App\Models\Communities\Community as Community;
use App\Http\Requests\ValidateTeacherFile as ValidateTeacherFile;
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
        if (\Gate::denies('create', 'user')) {
            abort(403);
        }

        //Get community id
        $filter['community'] = session('teachers_filter_community');

        if (!isset($filter['community'])) {
            $filter['community'] = \Auth::user()->community_id;
        }

        return view('admin.users.teachers.upload', [
            'filter' => $filter,
            'path' => 'usergroup/teachers',
            'urlUserList' => url('usergroup/teachers', 'list'),
            'communities' => Community::all(),
        ]);
    }

    /**
     * Upload the the user list.
     *
     * @param  ValidateTeacherFile  $request
     * @return Response
     */
    public function store(ValidateTeacherFile $request)
    {
        $community_id = $request->input('community_id');

        $path = $request->file('file_teachers')->store('users/'.$request->user()->id);

        $reader = \Excel::selectSheetsByIndex(0)->load('storage/app/'.$path);

        \Storage::delete($path);
        
        $list = $reader->select(array('first_name', 'last_name', 'middle_name', 'email', 'birthday', 'phone_number'))->get()->toArray();

        //Validate file by row
        $errors = $this->validateRow($list);

        if ($errors->all()) {
            return redirect('usergroup/teachers/upload')->withErrors($errors)->withInput();
        }

        //Store the student list in storage.
        foreach ($list as $row) {
            //Complete missed data
            $row['user_group_id'] = Usergroup::where('group', 'teachers')->first()->id;

            $row['community_id'] = $community_id;

            $row['login'] = $community_id.'_'.str_slug($row['last_name']).'_'.$row['user_group_id'];

            $row['password'] = str_random(6);

            $row['role_id'] = Role::where('role', 'respondent')->first()->id;
            
            if ($row['birthday']) {
                $row['birthday'] = Carbon::parse($row['birthday'])->toDateString();
            } else {
                $row['birthday'] = null;
            }

            //Store user data
            $user = User::create($row);
        }

        $message = ['flash_message'=> \Lang::get('admin/users.successfully_uploaded')];

        return back()->with($message);
    }

    /**
     * Validate row from uploaded file.
     *
     * @param  array  $list
     * @return Illuminate\Support\MessageBag
     */
    protected function validateRow($list)
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
                'email' => 'required|email|max:255|unique:users,email',
                'phone_number' => 'nullable|string|max:45|unique:users,phone_number',
                'birthday' => 'nullable|date_format:"d.m.Y"',
            ]);

            if ($validator->fails()) {
                $validator->errors()->add('row', \Lang::get('admin/users.row').$rowNumber);
                break;
            }

            //Additional check to avoid user duplicate in the list
            $validator->after(function ($validator) use ($row, $temp, $rowNumber) {
                if (in_array($row, $temp)) {
                    $validator->errors()->add('teacher_error', \Lang::get('admin/users.user_exists'));
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
