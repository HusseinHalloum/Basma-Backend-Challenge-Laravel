<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class RegisterCustomerRequest extends FormRequest
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
              'firstname' => 'bail|required|min:3|max:55|regex:/[a-z]/',
              'lastname'  =>'bail|required|min:3|max:55|regex:/[a-z]/',
              'email' =>  'bail|required|email|unique:customers',
              'phone' => 'bail|required|min:8|max:15',
              'location'  =>'bail|required|min:3|max:55|regex:/[a-z]/',
              'password' => 'bail|required|string|min:6|regex:/[@$!%*#?&]/',
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
            //   'firstname.min'  => 'firstname should be at least 3 letters',
            //   'firstname.max'  => 'firstname should be for maximum 55 letters',
              'firstname.regex' => 'please enter only lowercase or uppercase letters',
             
            //   'lastname.min'  => 'lastname should be at least 3 letters',
            //   'lastname.max'  => 'lastname should be for maximum 55 letters',
              'lastname.regex' => 'please enter only lowercase or uppercase letters',
              
            //   'email.required' => 'this field is required',
              'email.email' => 'please enter a valid email address',
              'email.unique' => 'this email already exist',
              
            //   'phone.required' => 'this field is required',
              'phone.min'  => 'phone should be at least 8 numbers',
              'phone.max'  => 'phone should be for maximum 15 numbers',

            //   'password.required' => 'this field is required',
              'password.min' => 'password must contain at least 6 character',
              'password.regex' => 'password must contain a special character',

              '*.required' => 'this field is required',
              '*.min' => 'this field should be at least 3 letters',
              '*.max' => 'this field should be for maximum 55 letters',
          ];
      }
  
      protected function failedValidation(Validator $validator)
      {
          throw new HttpResponseException(response()->json(['error' => $validator->errors()], 422));
      }
}
