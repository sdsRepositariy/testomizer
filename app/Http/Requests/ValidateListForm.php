<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ValidateListForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Action to authorize
        if (\Request::isMethod('POST')) {
            $action = 'create';
        } else {
            $action = 'update';
        }

        //Check permittion to perform an action.
        $prefix = str_replace("/", "", \Request::route()->getPrefix());
        if (\Gate::denies($action, $prefix)) {
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
        return [
            'name' => 'required|max:64',
            'description' => 'max:255',
        ];
    }
}
