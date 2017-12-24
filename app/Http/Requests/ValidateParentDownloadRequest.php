<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateParentDownloadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Check permittion to view a user with role respondent.
        if (\Gate::denies('view', 'user-respondent')) {
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
            'community' => 'required|exists:communities,id',
            'level' => 'exists:levels,id',
            'stream' => 'exists:streams,id',
            'period' => 'required|exists:periods,id',
        ];
    }

    /**
     * Configure the validator instance.
     *
     * @param  \Illuminate\Validation\Validator  $validator
     * @return void
    */
    public function withValidator($validator)
    {
        $validator->after(function ($validator) {
            if ($validator->errors()->all()) {
                $validator->errors()->add('download_error', \Lang::get('admin/users.download_failed'));

                //Get url of the user list
                if (session('parents_user_list') == null) {
                    $urlUserList = url('usergroup/parents', 'list');
                } else {
                    $urlUserList = session('parents_user_list');
                }
                
                $this->redirect = $urlUserList;
            }
        });
    }
}
