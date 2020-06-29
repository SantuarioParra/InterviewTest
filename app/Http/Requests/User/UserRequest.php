<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class UserRequest extends FormRequest
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
        switch ($this->method()) {
            case 'GET':
            case 'DELETE':
                {
                    return [];
                }
            case 'POST':
                {
                    return [
                        'name' => ['required','max:50','string',Rule::unique('users','name')],
                        'email' => ['required','email:dns',Rule::unique('users','email')],
                        'password' => ['required','min:8','confirmed'],
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => ['required','max:50','string',Rule::unique('users','name')->ignore($this->user,'id')],
                        /*'name'=>'required|string| unique:users,name'.$this['id'],*/
                        'email' => ['required','email','string',Rule::unique('users','email')->ignore($this->user,'id')],
                        'password' => 'required|min:8|confirmed',
                    ];
                }
            default:
                {
                    break;
                }
        }
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param Validator $validator
     * @return void
     *
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator));
        throw new HttpResponseException(
            response()->json(['message' => trans('messages.422_VALIDATION_ERROR'), 'errors' => $errors->errors()], 422)
        );
    }
}
