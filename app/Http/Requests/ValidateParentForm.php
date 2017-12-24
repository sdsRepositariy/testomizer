<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\User as User;

class ValidateParentForm extends FormRequest
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
        $rules = [
            'first_name' => [
                    'required',
                    "regex:/^[\pL\pM\pPd]+$/u",
                    'max:255',
            ],
            'middle_name' => [
                    "required",
                    "regex:/^[\pL\pM\pPd]+$/u",
                    'max:255',
            ],
            'last_name' => [
                    'required',
                    "regex:/^[\pL\pM\pPd]+$/u",
                    'max:255',
            ],
            'birthday' => 'nullable|date_format:"Y-m-d"',
        ];

        if ($this->route()->user) {
            $rules['email'] = 'required|email|max:255|unique:users,email,'.$this->route()->user->id;
            $rules['phone_number'] = 'string|nullable|max:45|unique:users,phone_number,'.$this->route()->user->id;
        } else {
            $rules['email'] = 'required|email|max:255|unique:users,email';
            $rules['phone_number'] = 'string|nullable|max:45|unique:users,phone_number';
        }

        return $rules;
    }
}
