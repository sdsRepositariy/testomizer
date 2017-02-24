<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateUser extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'first_name' => 'required|alpha|max:255',
            'middle_name' => 'required|alpha|max:255',
            'last_name' => 'required|alpha|max:255',
            'email' => 'required|unique:users,email|email|max:255',
            'phone_number' => 'required|max:255',
            'country' => 'alpha|max:255',
            'city' => 'alpha|max:255',
            'school_number' => 'numeric',
            'role_id' => 'filled',
            'password' => 'required|min:5|max:255',
        ];
    }
}
