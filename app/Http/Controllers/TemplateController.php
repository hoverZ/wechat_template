<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 13:33
 */

namespace App\Http\Controllers;


use App\Http\Requests\TemplateCreatePost;
use App\Http\Transforms\TemplateTransform;
use App\Models\Template;
use App\Services\WechatService;
use Dingo\Api\Http\Request;

/**
 * Class TemplateController
 * @package App\Http\Controllers
 *
 * @property \App\Models\Template                       $template
 */
class TemplateController extends TemplateBaseController
{

    /**
     * 创建消息模版
     * template_short_id 存在则不向微信公众号发起新建
     * @param TemplateCreatePost $request
     * @return mixed
     */
    public function create(TemplateCreatePost $request){
        $template = Template::where('template_short_id',$request->template_short_id)->first();
        $data = $request->all();
        $data['app_id'] = $this->app->id;
        if( $template ){
            $data['template_length_id'] = $template->template_length_id;
        }else{
            $result = WechatService::noticeOperationByApp($this->app->appid, $this->app->secret,
                WechatService::TEMPLATE_ADD, ['template_short_id' => $request->template_short_id]);
            if($result['errcode'] == 0){
                $data['template_length_id'] = $result['template_id'];
            }else{
                return $this->response->array($this->wechatJsonParse($result));
            }
        }
        $template = Template::create($data);
        if( $template === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    public function update(Request $request){
        $data = [
            'template_title' => $request->template_title ? $request->template_title : $this->template->template_title,
            'body_json' => $request->body_json ? $request->body_json: $this->template->body_json,
            'template_type' => $request->template_type? $request->template_type: $this->template->template_type,
        ];
        $this->template->fill($data);
        $status = $this->template->save();
        if($status === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    /**
     * 删除模版,删除微信端的消息模版
     * @return mixed
     */
    public function delete(){
        $result = WechatService::noticeOperationByApp($this->app->appid, $this->app->secret,
            WechatService::TEMPLATE_DELETE, ['template_id' => $this->template->template_length_id]);
        if($result['errcode'] != 0){
            return $this->response->array($this->wechatJsonParse($result));
        }
        $status = $this->template->delete();
        if($status == false){
            $this->response->error(trans('response.404'),404);
        }
        $this->response->error(trans('response.204'),204);
    }

    public function getList(Request $request){
        $per_page = $request->input('per_page',10);
        if(!is_numeric($per_page)){
            $this->response->error(trans('response.422'),422);
        }
        $template_list = Template::where('app_id', $this->app->id)->paginate($per_page);
        return $this->response->paginator($template_list, new TemplateTransform());
    }

    public function getItem(){
        $item = $this->template;
        if( !$item ){
            $this->response->error(trans('response.410'),410);
        }
        return $this->response->item($item,new TemplateTransform());
    }

}