<?php

namespace App\Http\Requests\Auth;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\Exceptions\HttpResponseException;
class RegisterRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    public function messages()
    {
        return [
            'name.required' => 'Name is required!',
            'name.max' => 'Name must be atmost 255 characters only!',
            'email.required' => 'Email is required!',
            'email.email' => 'Email is invalid!',
            'email.unique' => 'Email is already taken!',
            'password.required' => 'Password is required!',
            'password.confirmed' => 'Passwords donot match!',
            'password.max' => 'Password must be at atmost 8 characters!',
        ];
    }
    public function rules(): array
    {
        return [
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users|max:255',
            'password' => 'required|confirmed|max:255',
        ];
    }
    
    protected function failedValidation(Validator $validator)
    {
        $response = response()->json([
            'success' => false,
            'message' => $validator->errors()->first()
        ]);

        throw new HttpResponseException($response);
    }
}
