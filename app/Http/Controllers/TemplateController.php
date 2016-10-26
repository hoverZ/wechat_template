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
use Dingo\Api\Http\Request;

/**
 * Class TemplateController
 * @package App\Http\Controllers
 *
 * @property \App\Models\Template                       $template
 */
class TemplateController extends TemplateBaseController
{

    public function create(TemplateCreatePost $request){
        $template = Template::create($request->all());
        if( $template === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    public function update(Request $request){
        $this->template->fill($request->all());
        $status = $this->template->save();
        if($status === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    public function delete(){
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
        $template_list = Template::where('app_id', $app_id)->paginate($per_page);
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