<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/26
 * Time: 11:03
 */

namespace App\Services;


class RedisService
{
    const TEMPLATE_LIST = 'wechat_template_queue';

    private static $redis;

    public static function instance(){
        if( !self::$redis ){
            self::$redis = new \Redis();
            self::$redis->connect(env('REDIS_HOST'));
            self::$redis->auth(env('REDIS_PASSWORD'));
        }
        return self::$redis;
    }

    public static function pushToTemplateList( $app_id, $data){
        $data = [
            'app_id' => $app_id,
            'data' => $data,
        ];
        $str = json_encode($data);
        $redis = self::instance();
        if(! $redis->lPush(self::TEMPLATE_LIST, $str)){
            Log::error(" redis push fail pushToTemplateList app_id=[$app_id] data=[$str] ");
            return false;
        }else{
            return true;
        }
    }
}