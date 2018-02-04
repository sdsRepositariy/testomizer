<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Users\Grade as Grade;

class ValidateCommunityForm extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        //Check permittion to create a community.
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
        return [
            'country' => 'required',
            'region' => 'required',
            'city' => 'required',
            'number' => 'required|numeric',
            'name' => 'nullable|alpha_dash',
        ];
    }
}
