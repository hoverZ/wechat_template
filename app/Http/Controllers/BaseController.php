<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 12:01
 */

namespace App\Http\Controllers;



use Dingo\Api\Routing\Helpers;
use Illuminate\Http\Request;

class BaseController extends Controller
{
    use Helpers;

    /**
     * 检查参数是否合法,并返回错误情况
     * @param Request $request
     * @param $parameter_names
     * @return array
     */
    protected function checkParameter(Request $request, $parameter_names){
        $errors = [
            'required' => [],   // 保存缺少的参数名
            'type' => [],       // 保存类型错误的参数名
        ];
        foreach ( $parameter_names as $name => $type){
            if( !$request->has($name) ){
                $errors['required'][] = $name;
                continue;
            }
            if( !$this->checkParameterType($request->$name, $type) ){
                $errors['type'][] = $name;
            }
        }
        return $errors;
    }

    /**
     * 检查参数的类型
     * @param $parameter
     * @param $type
     * @return bool
     */
    protected function checkParameterType( $parameter, $type){
        switch ($type){
            case 'array':
                return is_array($parameter) ? $parameter : false;
            case 'int' :
                return is_int((int)$parameter) ? (int)$parameter: false;
            case 'number':
                return is_numeric($parameter) ? (float)$parameter: false;
            case 'json' :
                return isJson($parameter);
            default:
                return $parameter;
        }
    }

    /**
     * 错误信息
     * @param $parameter_errors
     * @param $name string 语言文件名
     * @return array
     */
    protected function parameterErr($parameter_errors, $name){
        $return_msg = [
            'message' => trans('response.422'),
            'status_code' => 422,
        ];
        $errors = [];
        foreach ($parameter_errors['required'] as $item){
            $errors["$item"][] = trans("$name.error.required.$item");
        }
        foreach ($parameter_errors['type'] as $item){
            $errors["$item"][] = trans("$name.error.type.$item");
        }
        $return_msg["errors"] = $errors;
        return $return_msg;
    }

    protected function checkArray($array){
        $errors = [
            'required' => [],   // 保存缺少的参数名
            'type' => [],       // 保存类型错误的参数名
        ];
        foreach ( $array as $name => $item){
            if( !$item["value"] ){
                $errors['required'][] = $name;
                continue;
            }
            if( !$this->checkParameterType($item["value"], $item["type"]) ){
                $errors['type'][] = $name;
            }
        }
        return $errors;
    }
}