<?php

namespace App\Domains\Admin\User\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreRequest extends FormRequest
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
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule],
            'email'     => ['required','email','regex:/^(?!.*[\/]).+@(?!.*[\/]).+\.(?!.*[\/]).+$/i','unique:users,email,NULL,id,deleted_at,NULL'],
            'phone'     => [ 'required', 'numeric', 'regex:/^[0-9]{7,15}$/', 'unique:users,phone,NULL,id,deleted_at,NULL'],
            'password'  => ['required', 'string', 'min:8','confirmed'],
        ];
    }
}
