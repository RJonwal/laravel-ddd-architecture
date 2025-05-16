<?php

namespace App\Domains\Admin\Milestone\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class MilestoneStoreRequest extends FormRequest
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
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule, 'unique:milestones,name,NULL,id,deleted_at,NULL'],
            'project_id'  => ['required', 'exists:projects,uuid'],
            'start_date'  => [
                'nullable',
                 'date'
            ],
            'end_date'    => [
                'nullable',
                'date'
            ],
        ];
    }
}
