<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\UserGroup as UserGroup;
use App\Models\Roles\Role as Role;
use App\Models\Communities\Community as Community;

class ValidateUpload extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Check permittion to create a user with given role.
        $role = Role::findOrFail(\Request::input('role_id'))->role;
        if (\Gate::denies('create', 'user-'.$role)) {
            return false;
        }

        //Check permittion to select a community.
        if (\Gate::denies('create', 'community')) {
            return false;
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
        //Email can be nullable for students
        if (\Route::input('usergroup')->group == 'students') {
            $email = 'nullable|email|max:255|unique:users,email,id'.$this->user()->id;
        } else {
            $email = 'email|required|max:255|unique:users,email,id'.$this->user()->id;
        }

        return [
            'first_name' => 'required|alpha|max:255',
            'middle_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'user_id' => 'sometimes|required|exists:users,id',
            'email' => $email,
            'phone_number' => 'nullable|max:45|unique:users,phone_number,id'.$this->user()->id,
            'birthday' => 'nullable|date_format:"Y-m-d"',
            'community_id' => 'sometimes|required|exists:communities,id',
            'role_id' => 'sometimes|required|exists:roles,id',
            'level_id' => 'sometimes|required|exists:levels,id',
            'stream_id' => 'sometimes|required|exists:streams,id',
            'period_id' => 'sometimes|required|exists:periods,id',
           
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            'first_name' => 'first name',
            'middle_name' => 'middle name',
            'last_name' => 'last name',
            'user_id' => 'parent',
            'phone_number' => 'phone number',
            'community_id' => 'community',
            'role_id' => 'role',
            'level_id' => 'level',
            'stream_id' => 'stream',
            'period_id' => 'period',
        ];
    }
}
