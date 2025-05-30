<?php

namespace App\Domains\Admin\Sprint\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class SprintStoreRequest extends FormRequest
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
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule, 'unique:sprints,name,NULL,id,deleted_at,NULL'],
            'project_id'  => ['required', 'exists:projects,uuid'],
            'start_date'  => [
                'nullable',
                 'date'
            ],
            'end_date'    => [
                'nullable',
                'date'
            ],
            'status' => ['required','in:'.implode(',',array_keys(config('constant.sprint_status')))],
        ];
    }

    public function attributes()
    {
        return [
            'name' => 'Sprint name',
            'project_id' => 'Project name',
            'start_date' => 'Start date',
            'end_date' => 'End date',
            'status' => 'Status',
        ];
    }
}
