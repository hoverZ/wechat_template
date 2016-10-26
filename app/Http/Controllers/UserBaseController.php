<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/25
 * Time: 15:28
 */

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;

/**
 * Class UserBaseController
 * @package App\Http\Controllers
 *
 * @property \App\User          $user
 */
class UserBaseController extends BaseController
{

    /**
     * 检查 token 的用户能否访问当前 url
     * UserBaseController constructor.
     * @param Request $request
     */
    public function __construct(Request $request)
    {

        try {

            if (! $this->user = JWTAuth::parseToken()->authenticate()) {
                $this->response->error(trans('response.user_not_found'), 404);
            }

            if( $this->user->id != $request->user_id){
                $this->response->error(trans('response.401'),401);
            }


        } catch (\Tymon\JWTAuth\Exceptions\TokenExpiredException $e) {

            $this->response->error(trans('response.token_expired'),401);

        } catch (\Tymon\JWTAuth\Exceptions\TokenInvalidException $e) {

            $this->response->error(trans('response.token_invalid'),401);

        } catch (\Tymon\JWTAuth\Exceptions\JWTException $e) {

            $this->response->error(trans('response.token_absent'),401);

        }
    }

}