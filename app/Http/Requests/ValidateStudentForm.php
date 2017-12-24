<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\UserGroup as UserGroup;
use App\Models\Roles\Role as Role;
use App\Models\Communities\Community as Community;
use Illuminate\Validation\Rule;
use App\Models\Users\User as User;
use App\Models\Users\Grade as Grade;

class ValidateStudentForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Check permittion to create a user with role respondent.
        if (\Gate::denies('create', 'user-respondent')) {
            return false;
        }

        //Check permittion to select a community.
        if (\Gate::denies('create', 'community')) {
            return \Request::input('community_id') == \Auth::user()->community_id;
        }
        
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $rules =  [
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
            'birthday' => 'required|date_format:"Y-m-d"',
            'community_id' => 'required|exists:communities,id',
            'level_id' => 'required|exists:levels,id',
            'stream_id' => 'required|exists:streams,id',
            'period_id' => 'required|exists:periods,id',
        ];

        if ($this->route()->user) {
            $rules['email'] = 'nullable|email|max:255|unique:users,email,'.$this->route()->user->id;
            $rules['phone_number'] = 'nullable|string|max:45|unique:users,phone_number,'.$this->route()->user->id;
        } else {
            $rules['email'] = 'nullable|email|max:255|unique:users,email';
            $rules['phone_number'] = 'nullable|string|max:45|unique:users,phone_number';
        }

        return $rules;
    }

    /**
    * Configure the validator instance.
    *
    * @param  \Illuminate\Validation\Validator  $validator
    * @return void
    */
    public function withValidator($validator)
    {
        $request = \Request::instance();

        //Additional check to avoid user duplicate
        if ($request->isMethod('POST')) {
            $validator->after(function ($validator) use ($request) {
                $user = User::where([
                    ['first_name', $request->input('first_name')],
                    ['middle_name', $request->input('middle_name')],
                    ['last_name', $request->input('last_name')],
                    ['community_id', $request->input('community_id')],
                    ['birthday', $request->input('birthday')]
                ])->first();
                if ($user !== null) {
                    $validator->errors()->add('student_error', \Lang::get('admin/users.user_exists'));
                }
            });
        }

        //The grade could be absent for given period
        if ($request->isMethod('PUT')) {
            $validator->after(function ($validator) use ($request) {
                $grade = Grade::where([
                    ['level_id', $request->input('level_id')],
                    ['period_id', $request->input('period_id')],
                    ['stream_id', $request->input('stream_id')],
                    ['community_id', $request->input('community_id')],
                ])->first();

                if ($grade == null) {
                    $validator->errors()->add('student_error', \Lang::get('admin/users.absent_grade'));
                }
            });
        }
    }
}
