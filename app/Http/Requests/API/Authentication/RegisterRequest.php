<?php

namespace App\Http\Requests\API\Authentication;

use App\Http\Requests\API\FormRequest;
use Illuminate\Validation\Rule;

class RegisterRequest extends FormRequest
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
            'username' => [
                'required',
                'string',
                Rule::unique('users','username')
            ],
            'password' => [
                'required',
                'string',
                'confirmed'
            ],
        ];
    }
}
