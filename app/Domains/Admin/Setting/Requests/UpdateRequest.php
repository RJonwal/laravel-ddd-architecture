<?php

namespace App\Domains\Admin\Setting\Requests;

use App\Rules\NoMultipleSpacesRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    public function rules()
    {
        $rules = [];
        $rules['setting_type'] = ['required', 'in:site,support'];
        if($this->setting_type == 'site'){
            $rules['site_title'] = ['required'];
            $rules['site_logo'] = ['image', 'mimes:jpeg,png,jpg,PNG,JPG'];
            $rules['favicon'] = ['image', 'mimes:jpeg,png,jpg,PNG,JPG'];
        } else if($this->setting_type == 'support'){
            $rules['user_pagination'] = ['required'];
            $rules['technology_pagination'] = ['required'];
            $rules['project_pagination'] = ['required'];
            $rules['milestone_pagination'] = ['required'];
            $rules['task_pagination'] = ['required'];
            $rules['daily_task_pagination'] = ['required'];
        }

        return $rules;
    }
    
    public function messages()
    {
        return [
            'site_logo.image' => 'The site logo must be an image.',
            'site_logo.mimes' => 'The site logo must be jpeg,png,jpg,PNG,JPG.',
            'favicon.image' => 'The favicon must be an image.',
            'favicon.mimes' => 'The favicon must be jpeg,png,jpg,PNG,JPG.',
        ];
    }

}
?>