<?php

/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/24
 * Time: 16:26
 */
namespace App\Http\Core;

class MyAccessToken extends \EasyWeChat\Core\AccessToken
{
    private $access_token = "";
    public function __construct( $access_token )
    {
        $this->access_token = $access_token;
    }

    public function getToken($forceRefresh = false)
    {
        return $this->access_token;
    }
}