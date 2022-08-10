<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

abstract class BaseRequest extends FormRequest
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
    abstract function rules();

    /**
     * @param Illuminate\Contracts\Validation\Validator $validator
     * @throws Illuminate\Validation\ValidationException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = array_map(fn($e) => $e[0], $validator->errors()->toArray());
        // Priority for token errors
        if (array_key_exists('token', $errors)) {
            $errors = ['token' => $errors['token']];
        }

        $response = new JsonResponse([
            'status' => 422,
            'data' => $errors,
            'message' => __('messages.validation_failed'),
        ], 422);

        throw new ValidationException($validator, $response);
    }
}
