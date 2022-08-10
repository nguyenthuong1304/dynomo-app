<?php

namespace App\Http\Requests;

class RegisterRequest extends BaseRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'username' => 'required|string|min:6|max:32|unique:users',
            'password' => 'required|min:6|max:32|string|password',
            'email' => 'required|email|unique:users',
        ];
    }
}
