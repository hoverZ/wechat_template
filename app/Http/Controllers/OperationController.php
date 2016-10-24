<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/24
 * Time: 09:37
 */

namespace App\Http\Controllers;


use App\Http\Requests\IndustryPost;
use App\Services\WechatService;
use Dingo\Api\Http\Request;

class OperationController extends BaseController
{

    /**
     * 微信返回信息拼接
     * @param $result
     * @return array
     */
    private function wechatJsonParse( $result ){
        $status_code = 200;
        if($result['errcode'] != 0){
            $status_code = 422;
        }
        return array(
            'message' => trans("wechat.$status_code"),
            'wechat_return' => $result,
            'status_code' => $status_code,
        );
    }

    /**
     * 修改行业信息
     * @param IndustryPost $request
     * @return mixed
     */
    public function setIndustryByClient(IndustryPost $request){
        $data = [
            'industry1' => $request->industry1,
            'industry2' => $request->industry2,
        ];
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret, WechatService::INDUSTRY_SET, $data);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 获取该行业信息
     * @param Request $request
     * @return mixed
     */
    public function getIndustryByClient(Request $request){
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret, WechatService::INDUSTRY_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 添加模版
     * @param Request $request
     * @return mixed
     */
    public function addTemplateByClient(Request $request){
        $parameter_array = [
            'template_short_id' => 'string',
        ];
        $errors = $this->checkParameter($request, $parameter_array);
        if( count($errors['required']) > 0 || count($errors['type']) > 0){
            return $this->response->array($this->parameterErr($errors,'wechat'));
        }
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret,
            WechatService::TEMPLATE_ADD, ['template_short_id' => $request->template_short_id]);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 发送模版消息
     * @param Request $request
     * @return mixed
     */
    public function sendTemplateByClient(Request $request){
        $json_str = urldecode($request->template_data);
        $data = json_decode($json_str, true);
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret, WechatService::TEMPLATE_SEND, $data);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPrivateTemplates(Request $request){
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret, WechatService::TEMPLATE_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deletePrivateTemplate(Request $request){
        $result = WechatService::noticeOperationByApp($request->app_id, $request->secret, WechatService::TEMPLATE_DELETE,
            ['template_id' => $request->template_id]);
        return $this->response->array($this->wechatJsonParse($result));
    }


    /**
     * 修改行业信息
     * @param Request $request
     * @return mixed
     */
    public function setIndustryByToken(Request $request){
        $data = [
            'industry1' => $request->industry1,
            'industry2' => $request->industry2,
        ];
        $result = WechatService::noticeOperationByToken($request->token, WechatService::INDUSTRY_SET, $data);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 获取该行业信息
     * @param Request $request
     * @return mixed
     */
    public function getIndustryByToken(Request $request){
        $result = WechatService::noticeOperationByToken($request->token, WechatService::INDUSTRY_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 添加模版
     * @param Request $request
     * @return mixed
     */
    public function addTemplateByToken(Request $request){
        $parameter_array = [
            'template_short_id' => 'string',
        ];
        $errors = $this->checkParameter($request, $parameter_array);
        if( count($errors['required']) > 0 || count($errors['type']) > 0){
            return $this->response->array($this->parameterErr($errors,'wechat'));
        }
        $result = WechatService::noticeOperationByToken($request->token,
            WechatService::TEMPLATE_ADD, ['template_short_id' => $request->template_short_id]);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 发送模版消息
     * @param Request $request
     * @return mixed
     */
    public function sendTemplateByToken(Request $request){
        $json_str = urldecode($request->template_data);
        $data = json_decode($json_str, true);
        $result = WechatService::noticeOperationByToken($request->token, WechatService::TEMPLATE_SEND, $data);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function getPrivateTemplatesByToken(Request $request){
        $result = WechatService::noticeOperationByToken($request->token, WechatService::TEMPLATE_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * @param Request $request
     * @return mixed
     */
    public function deletePrivateTemplateByToken(Request $request){
        $result = WechatService::noticeOperationByToken($request->token, WechatService::TEMPLATE_DELETE,
            ['template_id' => $request->template_id]);
        return $this->response->array($this->wechatJsonParse($result));
    }

}