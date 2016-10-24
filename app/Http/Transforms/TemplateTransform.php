<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 13:35
 */

namespace App\Http\Transforms;


use App\Models\Template;
use League\Fractal\TransformerAbstract;

class TemplateTransform extends TransformerAbstract
{

    public function transform(Template $item){
        return [
            'id' => $item->id,
            'template_id' => $item->template_id,
            'template_title' => $item->template_title,
            'app_id' => $item->app_id,
            'template_type' => $item->template_type,
            'template_status' => $item->template_status,
            'created_at' => $item->created_at,
            'update_at' => $item->update_at,
        ];
    }

}