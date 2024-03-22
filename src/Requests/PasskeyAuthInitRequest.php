<?php

namespace Mohdradzee\Waident\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PasskeyAuthInitRequest extends FormRequest
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
            'username' => 'required|max:50'
        ];
    }

    /**
     * Get the validation custom error message.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => trans('default.request_username_required'),
        ];
    }
}
