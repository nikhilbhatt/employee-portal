<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ClientRequest extends FormRequest
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
            'name' => 'required|string',
            'emails' => 'nullable|string',
            'phone' => 'nullable|string',
            'country' => 'nullable|string',
            'is_active' => 'nullable|boolean',
            'address' => 'nullable|string',
            'gst_num' => 'nullable|string',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => 'Client name is required',
            'email.email' => 'Client email should be a valid email address',
        ];
    }
}
