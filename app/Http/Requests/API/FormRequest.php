<?php

namespace App\Http\Requests\API;

use Illuminate\Contracts\Validation\Validator;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Foundation\Http\FormRequest AS BaseFormRequest;

class FormRequest extends BaseFormRequest
{
    /**
     * Formats the validation errors
     *
     * @return array
     */
    public function _formatErrors($validationErrors): array{
        $errors           = [];
        $validationErrors = $validationErrors->getMessages();
        foreach ($validationErrors AS $key => $error) {
            $errors[$key] = $error[0];
        }

        return $errors;
    }

    /**
     * Handle a failed validation attempt.
     *
     * @param  Validator  $validator
     *
     * @return void
     *
     * @throws HttpResponseException
     */
    public function failedValidation(Validator $validator)
    {
        throw new HttpResponseException(
            response()
                ->json([
                'message' => 'Validation failed',
                'data'    => [],
                'errors'  => $this->_formatErrors($validator->errors())
            ], Response::HTTP_UNPROCESSABLE_ENTITY)
        );
    }
}
