<?php

namespace App\Domains\Admin\Technology\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class TechnologyUpdateRequest extends FormRequest
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
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule, 'unique:technologies,name,'. $this->technology->id.',id,deleted_at,NULL'],
            'technology_type'  => ['required', "in:".implode(',', array_keys(config('constant.technology_types')))],
        ];
    }
}
