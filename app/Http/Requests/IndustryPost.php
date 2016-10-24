<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/24
 * Time: 11:39
 */

namespace App\Http\Requests;


class IndustryPost extends BaseRequest
{
    public function rules()
    {
        return [
            'industry1' => 'required',
            'industry2' => 'required',
        ];
    }

    public function messages()
    {
        return [
            'industry1.required' => '',
            'industry2.required' => '',
        ];
    }

}