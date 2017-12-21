<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\Grade as Grade;

class ValidateStudentFile extends FormRequest
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
        return [
            'file_students' => 'required|mimes:xls,xlsx,ods|max:200',
            'community_id' => 'required|exists:communities,id',
            'period_id' => 'required|exists:periods,id',
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
        $request = \Request::instance();

        //For the upload period must not be any users in the grades
        $validator->after(function ($validator) use ($request) {
            $grades = Grade::where([
                ['period_id', $request->input('period_id')],
                ['community_id', $request->input('community_id')],
            ])->get();

            if (!$grades->isEmpty()) {
                foreach ($grades as $grade) {
                    if (!$grade->users()->get()->isEmpty()) {
                        $validator->errors()->add('file_students', \Lang::get('admin/users.students_exist'));
                    }
                }
            }
        });
    }
}
