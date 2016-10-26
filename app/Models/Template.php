<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 11:59
 */

namespace App\Models;


class Template extends BaseModel
{
    protected $fillable = [
        'app_id','template_short_id','template_title','template_status','template_type','body_json'
    ];
}