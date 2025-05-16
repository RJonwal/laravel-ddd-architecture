<?php

namespace App\Domains\Admin\Task\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class TaskStoreRequest extends FormRequest
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
            'name'  => ['required', 'regex:/^[a-zA-Z\s]+$/', 'string', 'max:255', new NoMultipleSpacesRule, 'unique:tasks,name,NULL,id,deleted_at,NULL'],
            'project_id' => ['required', 'exists:projects,uuid'],
            'milestone_id'  => ['required', 'exists:milestones,uuid'],
            'parent_task_id' => ['nullable', 'exists:tasks,uuid'],
            'user_id' => ['required', 'exists:users,uuid'],
            'description' => ['nullable'],
            'estimated_time' => ['required', 'numeric', 'min:0'],
            'priority' => ['required','in:'.implode(',',array_keys(config('constant.task_priority')))],
            'status' => ['required','in:'.implode(',',array_keys(config('constant.task_status')))]
        ];
    }
}
