<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 13:19
 */

namespace App\Http\Transforms;

use App\Models\App;
use League\Fractal\TransformerAbstract;

class AppTransform extends TransformerAbstract
{

    public function transform(App $item){
        return [
            'id' => $item->id,
            'app_name' => $item->app_name,
            'appid' => $item->appid,
            'secret' => $item->secret,
            'fail_call_back_url' => $item->fail_call_back_url,
            'app_status' => $item->app_status,
            'channel' => $item->channel,
            'created_at' => $item->created_at,
            'update_at' => $item->update_at,
        ];
    }

}