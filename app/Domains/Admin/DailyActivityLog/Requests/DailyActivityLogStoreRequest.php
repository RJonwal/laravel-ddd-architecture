<?php

namespace App\Domains\Admin\DailyActivityLog\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class DailyActivityLogStoreRequest extends FormRequest
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
            'project_id' => [
                'required',
                'exists:projects,uuid'
            ],
            'milestone_id' => [
                'required',
                'exists:milestones,uuid'
            ],
            
            'report_date' => [
                'required',
                'date'
            ],
            
            /* tasks  */
            'daily_activity.*.task_id' => [
                'required',
                'exists:tasks,uuid',
            ],
            'daily_activity.*.sub_task_id' => [
                'nullable',
                'exists:tasks,uuid',
                'distinct',
            ],
            'daily_activity.*.task_type' => [
                'required',
                'in:'.implode(',',array_keys(config('constant.task_types'))),
            ],
            'daily_activity.*.status' => [
                'required',
                'in:'.implode(',',array_keys(config('constant.activity_status'))),
            ],
            'daily_activity.*.work_time' => [
                'required',                
            ],
            'daily_activity.*.description' => [
                'required',
            ],
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => 'Project name',
            'milestone_id' => 'Milestone name',

            'daily_activity.*.task_id' => 'Task',
            'daily_activity.*.sub_task_id' => 'Sub Task',
            'daily_activity.*.description' => 'Description',
            'daily_activity.*.task_type'   => 'Task Type',
            'daily_activity.*.work_time' => 'Work Time',
            'daily_activity.*.status' => 'Status',
        ];
    }
}
