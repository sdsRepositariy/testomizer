<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\UserGroup as UserGroup;
use App\Models\Roles\Role as Role;
use App\Models\Communities\Community as Community;
use Illuminate\Validation\Rule;
use App\Models\Users\User as User;

class ValidateTeacherForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Role wich user intend to attach
        $role = Role::find(\Request::input('role_id'))->role;

        //Action to authorize
        if (\Request::isMethod('POST')) {
            $action = 'create';
        } else {
            $action = 'update';
        }

        //Check permittion to perform an action.
        if (\Gate::denies($action, 'user-'.$role)) {
            return false;
        }

        //Check permittion to select a community.
        if (\Gate::denies($action, 'community')) {
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
            'birthday' => 'nullable|date_format:"Y-m-d"',
            'community_id' => 'required|exists:communities,id',
        ];

        if ($this->route()->user) {
            $rules['email'] = 'required|email|max:255|unique:users,email,'.$this->route()->user->id;
            $rules['phone_number'] = 'nullable|string|max:45|unique:users,phone_number,'.$this->route()->user->id;
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['phone_number'] = 'nullable|string|max:45|unique:users,phone_number';
        }

        return $rules;
    }
}
