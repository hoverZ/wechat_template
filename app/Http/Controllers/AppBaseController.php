<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/25
 * Time: 18:25
 */

namespace App\Http\Controllers;

use Dingo\Api\Http\Request;
use App\Models\App;
/**
 * Class AppBaseController
 * @package App\Http\Controllers
 *
 * @property \App\Models\App            $app
 */
class AppBaseController extends UserBaseController
{
    /**
     * 检查url中含有 app_id 时是否有权限访问
     * AppController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {
        parent::__construct($request);
        if( $request->app_id ){
            $this->app = App::find($request->app_id);

            if( !$this->app ){
                $this->response->error(trans('response.app_not_found'),401);
            }

            if( $this->app->user_id != $this->user->id ){
                $this->response->error(trans('response.401'),401);
            }

        }
    }
}