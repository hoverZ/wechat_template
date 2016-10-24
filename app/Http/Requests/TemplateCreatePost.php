<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 13:38
 */

namespace App\Http\Requests;


class TemplateCreatePost extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'app_id' => 'required',
            'template_id' => 'required',
            'template_title' => 'required',
            'template_type' => 'required',
            'body_json' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'app_id.required' => trans('template.error.required.app_id'),
            'template_id.required' => trans('template.error.required.template_id'),
            'template_title.required' => trans('template.error.required.template_title'),
            'template_type.required' => trans('template.error.required.template_type'),
            'body_json.required' => trans('template.error.required.body_json'),
        ];
    }

}