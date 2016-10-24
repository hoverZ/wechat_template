<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AppCreatePost extends BaseRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'appid' => 'required',
            'secret' => 'required',
            'app_name' => 'required',
            'fail_call_back_url' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'appid.required' => trans('app.error.required.appid'),
            'secret.required' => trans('app.error.required.secret'),
            'app_name.required' => trans('app.error.required.app_name'),
            'fail_call_back_url.required' => trans('app.error.required.fail_call_back_url'),
        ];
    }
}
