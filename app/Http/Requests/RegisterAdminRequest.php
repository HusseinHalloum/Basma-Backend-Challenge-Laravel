<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterAdminRequest extends FormRequest
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
              'firstname' => 'required|min:3|max:55|regex:/[a-z]/',
              'lastname'  =>'required|min:3|max:55|regex:/[a-z]/',
              'email' =>  'required|email|unique:admins',
              'phone' => 'required|min:8|max:15',
              'password' => 'required|string|min:6|regex:/[@$!%*#?&]/',
              // 'image'     => 'image|mimes:jpeg,jpg,svg,png,gif|max:2048',
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
              'firstname.min'  => 'firstname should be at least 3 letters',
              'firstname.max'  => 'firstname should be for maximum 55 letters',
              'firstname.regex' => 'Please enter only lowercase or uppercase letters',
             
              'lastname.min'  => 'lastname should be at least 3 letters',
              'lastname.max'  => 'lastname should be for maximum 55 letters',
              'lastname.regex' => 'Please enter only lowercase or uppercase letters',
              
              'email.unique' => 'Email already Exist.',
              'email.required' => 'this field is required',
              'email.email' => 'Please enter a valid email address',
              'email.unique' => 'this email already exist',
              
              'phone.required' => 'this field is required',
              'phone.min'  => 'phone should be at least 3 numbers',
              'phone.max'  => 'phone should be for maximum 15 numbers',

              'password.required' => 'this field is required',
              'password.min' => 'Password must contain at least 6 character',
              'password.regex' => 'Password must contain a special character',
          ];
      }
  
      protected function failedValidation(Validator $validator)
      {
          throw new HttpResponseException(response()->json(['error' => $validator->errors()], 422));
      }
}
