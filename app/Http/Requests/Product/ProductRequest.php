<?php

namespace App\Http\Requests\Product;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class ProductRequest extends FormRequest
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
                        'name' => ['required','max:50','string'],
                        'slug' => ['required','string',Rule::unique('products','slug')],
                        'description' => ['filled','string'],
                        'price'=> ['numeric','required'],
                        'status'=> ['boolean']
                    ];
                }
            case 'PUT':
            case 'PATCH':
                {
                    return [
                        'name' => ['required','max:50','string'],
                        'slug' => ['required','string',Rule::unique('products','slug')->ignore($this->product)],
                        'description' => ['filled','string'],
                        'price'=> ['numeric','required'],
                        'status'=> ['boolean']
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
