<?php
/**
 * Created by PhpStorm.
 * User: beechen
 * Date: 16/10/25
 * Time: 09:12
 */

namespace App\Http\Controllers;


class UserOperationController extends UserBaseController
{
    public function getUser(){
        return $this->response->array($this->user);
    }

    public function setIndustryByClient(){

    }

}