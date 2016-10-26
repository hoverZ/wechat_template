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

/**
 * Class AppController
 * @package App\Http\Controllers
 */
class AppController extends AppBaseController
{

    /**
     * 创建应用
     * @param AppCreatePost $request
     */
    public function create(AppCreatePost $request){
        $user_id = $request->user_id;
        $data = $request->all();
        $data["user_id"] = $user_id;
        $app = App::create($data);
        if( $app === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    /**
     * 更新应用
     * @param Request $request
     */
    public function update(Request $request){
        $this->app->fill($request->all());
        $status = $this->app->save();
        if($status === false){
            $this->response->error(trans('response.400'),400);
        }
        $this->response->error(trans('response.200'),200);
    }

    /**
     * 删除应用
     * @param Request $request
     */
    public function delete(Request $request){
        $status = $this->app->delete();
        if($status == false){
            $this->response->error(trans('response.404'),404);
        }
        $this->response->error(trans('response.204'),204);
    }

    /**
     * 获取应用列表
     * @param Request $request
     * @return \Dingo\Api\Http\Response
     */
    public function getList(Request $request){
        $per_page = $request->input('per_page',10);
        if(!is_numeric($per_page)){
            $this->response->error(trans('response.422'),422);
        }
        $app_list = App::where('user_id', $this->user->id)->paginate($per_page);
        return $this->response->paginator($app_list, new AppTransform());
    }

    /**
     * 获取应用信息
     * @return \Dingo\Api\Http\Response
     */
    public function getItem(){
        $item = $this->app;
        if( !$item ){
            $this->response->error(trans('response.410'),410);
        }
        return $this->response->item($item,new AppTransform());
    }

}