<?php

namespace App\Domains\Admin\Project\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class ProjectStoreRequest extends FormRequest
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
            'name'     => [
                'required',
                'string',
                'max:191',
                'unique:projects,name',
            ],
            
            'project_lead'  => [
                'required',
                'exists:users,uuid',
            ],
            'assign_developers'  =>[
                'required',
                'array',
                'exists:users,uuid',
            ],
            'start_date' => [
                'nullable',
                // 'required',
                'date',
            ],
            'end_date' => [
                'nullable',
                // 'required',
                'date',
            ],
            'technology'   => [
                'nullable',
                'array',
                // 'required',
                'exists:technologies,id'
            ],
            'live_url' => 'nullable|url',
            'project_status' => [
                'nullable',
                // 'required',
                'in:'.implode(',',array_keys(config('constant.project_status'))),
            ],
        ];
    }
}
