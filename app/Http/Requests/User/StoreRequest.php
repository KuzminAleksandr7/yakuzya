<?php

namespace App\Http\Requests\User;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rules\Password;

class StoreRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'firstname'   => ['required','string','min:2','max:60'],
            'lastname'    => ['required','string','min:2','max:60'],
            'email'       => ['required','email:rfc', 'unique:users,email'],
            'phone'       => ['required','regex:/^\+380\d{9}$/', 'unique:users,phone'],
            'photo'       => ['required','image','mimes:jpg,jpeg','dimensions:min_width=70,min_height=70','max:5120'],
            'position_id' => ['required','exists:positions,id'],
            'password'    => ['required', 'confirmed', Password::defaults()],
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if (isset($validator->failed()['email']['Unique']) || isset($validator->failed()['phone']['Unique'])) {
            $response = new JsonResponse([
                'success' => false,
                'message' => 'User with this phone or email already exist'
            ], 409);
        } else {
            $response = new JsonResponse([
                'success' => false,
                'message' => 'Validation failed',
                'fails' => $validator->errors()
            ], 422);
        }

        throw new HttpResponseException($response);
    }
}
