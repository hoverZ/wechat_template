<?php

/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/24
 * Time: 09:18
 */

namespace App\Services;

use App\Http\Core\MyAccessToken;
use EasyWeChat;
use EasyWeChat\Foundation\Application;
use EasyWeChat\Core\Exceptions\HttpException;
use EasyWeChat\Notice\Notice;

class WechatService
{
    const INDUSTRY_SET = 1;
    const INDUSTRY_GET = 2;
    const TEMPLATE_ADD = 3;
    const TEMPLATE_SEND = 4;
    const TEMPLATE_GET = 5;
    const TEMPLATE_DELETE = 6;

    /**
     * 根据 app_id 和 secret 获取 notice
     * @param $app_id
     * @param $secret
     * @param $type
     * @param array $data
     * @return array|EasyWeChat\Support\Collection
     */
    public static function noticeOperationByApp( $app_id, $secret, $type, $data = []){
        $options = [
            'app_id' => $app_id,
            'secret' => $secret,
        ];
        $application = new Application($options);

        $notice = $application->notice;
        return self::noticeOperation($notice, $type, $data);
    }

    /**
     * 根据 token 获取 notice
     * @param $token
     * @param $type
     * @param array $data
     * @return array|EasyWeChat\Support\Collection
     */
    public static function noticeOperationByToken( $token, $type, $data = []){
        $my_access_token = new MyAccessToken($token);
        $notice = new Notice($my_access_token);
        return self::noticeOperation($notice, $type, $data);
    }

    /**
     * @param Notice $notice
     * @param $type
     * @param $data
     * @return array|EasyWeChat\Support\Collection
     */
    private static function noticeOperation( Notice $notice, $type, $data){
        try{
            switch ($type){
                case self::INDUSTRY_SET:
                    $result = $notice->setIndustry( $data['industry1'], $data["industry2"]);
                    break;
                case self::INDUSTRY_GET:
                    $result = $notice->getIndustry();
                    break;
                case self::TEMPLATE_ADD:
                    $result = $notice->addTemplate($data["template_short_id"]);
                    break;
                case self::TEMPLATE_SEND:
                    $result = $notice->send($data);
                    break;
                case self::TEMPLATE_GET:
                    $result = $notice->getPrivateTemplates();
                    break;
                case self::TEMPLATE_DELETE:
                    $result = $notice->deletePrivateTemplate($data['template_id']);
                    break;
                default:
                    $result = [];
                    break;
            }
        }catch (HttpException $e){
            $result = [
                'errcode' => $e->getCode(),
                'errmsg' => $e->getMessage(),
            ];
        }
        return $result;
    }

}