<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateTeacherFile extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Check permittion to create a user with role respondent.
        //All uploaded users will be assigned for respondent role
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
        return [
            'file_teachers' => 'required|mimes:xls,xlsx,ods|max:200',
            'community_id' => 'required|exists:communities,id',
        ];
    }
}
