<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 09:59
 */

namespace App\Http\Requests;


use Dingo\Api\Http\FormRequest;

abstract class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    abstract function rules();
}