<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/25
 * Time: 09:12
 */

namespace App\Http\Controllers;


use App\Http\Requests\IndustryPost;
use App\Services\WechatService;
use Dingo\Api\Http\Request;

class UserOperationController extends AppBaseController
{
    public function getUser(){
        return $this->response->array($this->user);
    }

    /**
     * 设置行业信息
     * @param IndustryPost $request
     * @return mixed
     */
    public function setIndustry(IndustryPost $request){
        $data = [
            'industry1' => $request->industry1,
            'industry2' => $request->industry2,
        ];
        $result = WechatService::noticeOperationByApp($this->app->appid, $this->app->secret, WechatService::INDUSTRY_SET, $data);
        return $this->response->array($this->wechatJsonParse($result));
    }

    public function getIndustry(){
        $result = WechatService::noticeOperationByApp( $this->app->appid, $this->app->secret, WechatService::INDUSTRY_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

    /**
     * 发送模版消息
     * @return mixed
     */
    public function sendTemplate(Request $request){
        $openids = json_decode( $request->openids, 1);

    }

    /**
     * @return mixed
     */
    public function getPrivateTemplates(){
        $result = WechatService::noticeOperationByApp($this->app->appid, $this->app->secret, WechatService::TEMPLATE_GET);
        return $this->response->array($this->wechatJsonParse($result));
    }

}