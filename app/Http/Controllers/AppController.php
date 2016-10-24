<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/23
 * Time: 09:50
 */

namespace App\Http\Controllers;


use App\Http\Requests\AppCreatePost;
use App\Http\Transforms\AppTransform;
use App\Models\App;
use Dingo\Api\Http\Request;

class AppController extends BaseController
{

    public function create(AppCreatePost $request){
        $app = App::create($request->all());
        if( $app === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    public function update(Request $request,$app_id){
        $app = App::find($app_id);
        $app->fill($request->all());
        $status = $app->save();
        if($status === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    public function delete($app_id){
        $status = App::destroy($app_id);
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
        $app_list = App::paginate($per_page);
        return $this->response->paginator($app_list, new AppTransform());
    }

    public function getItem($app_id){
        $item = App::find($app_id);
        if( !$item ){
            $this->response->error(trans('response.410'),410);
        }
        return $this->response->item($item,new AppTransform());
    }

}