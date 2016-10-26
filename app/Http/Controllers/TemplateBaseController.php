<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/25
 * Time: 18:28
 */

namespace App\Http\Controllers;

use Dingo\Api\Http\Request;
use App\Models\Template;

/**
 * Class TemplateBaseController
 * @package App\Http\Controllers
 *
 * @property \App\Models\Template       $template
 */
class TemplateBaseController extends AppBaseController
{

    public function __construct(Request $request)
    {
        parent::__construct($request);
        if( $request->template_id ){
            $this->template = Template::find($request->template_id);

            if( !$this->template ){
                $this->response->error(trans('response.template_not_found'),401);
            }

            if( $this->template->app_id != $this->app->id ){
                $this->response->error(trans('response.401'),401);
            }

        }

    }

}