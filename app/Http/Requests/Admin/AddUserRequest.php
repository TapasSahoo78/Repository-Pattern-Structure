<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class AddUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'firstname'     => 'required|string',
            'lastname'      => 'required|string',
            'gender'        => 'required|string|in:male,female,transgender',
            'phone_number'  => 'required|numeric|gte:6000000000|lte:9999999999',
            'birthday'      => 'required|date_format:Y-m-d|before:-18 years',
            'address'       => 'required|string|max:255',
            'pin_code'      => 'required|numeric|min:100000|max:999999',
            'state'         => 'required|string|exists:states,slug',
            'city'          => 'required|string|exists:districts,slug',
            'email'         => 'required|email|unique:users,email',
            'password'      => 'required|string|min:6|regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{6,}$/',
        ];
    }
}
