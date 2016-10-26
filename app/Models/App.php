<?php

/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 11:58
 */

namespace App\Models;

class App extends BaseModel
{
    protected $fillable = [
        'appid','secret','app_name','app_status','channel','fail_call_back_url','user_id'
    ];
}