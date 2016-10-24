<?php


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

$api = app('Dingo\Api\Routing\Router');

$api->version('v1', function ($api) {

    $api->get('index',function(){

        return "index";

    });

    $api->group(['prefix' => 'client', 'namespace' => 'App\Http\Controllers'],function ($api){

        $api->group([ 'prefix' => 'wechat/apps/{token}'], function ($api){

            $api->post('/industry', 'OperationController@setIndustryByToken');

            $api->get('/industry', 'OperationController@getIndustryByToken');

            $api->post('/templates', 'OperationController@addTemplateByToken');

            $api->get('/templates/send/{template_data}', 'OperationController@sendTemplateByToken');

            $api->get('/templates', 'OperationController@getPrivateTemplatesByToken');

            $api->delete('/templates/{template_id}', 'OperationController@deletePrivateTemplateByToken');

        });

        $api->group([ 'prefix' => 'wechat/apps/{app_id}/{secret}'], function ($api){

            $api->post('/industry', 'OperationController@setIndustryByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/industry', 'OperationController@getIndustryByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->post('/templates', 'OperationController@addTemplateByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/templates/send/{template_data}', 'OperationController@sendTemplateByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/templates', 'OperationController@getPrivateTemplates')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->delete('/templates/{template_id}', 'OperationController@deletePrivateTemplate')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+',
            ));

        });

    });

    $api->group( ['prefix' => 'apps', 'namespace' => 'App\Http\Controllers'], function($api){

        $api->post('/','AppController@create');

        $api->put('/{app_id}', 'AppController@update')->where('app_id', '[0-9]+');

        $api->delete('/{app_id}', 'AppController@delete')->where('app_id', '[0-9]+');

        $api->get('/{app_id}', 'AppController@getItem')->where('app_id', '[0-9]+');

        $api->get('/', 'AppController@getList');

        $api->group([ 'prefix' => '{app_id}/template'], function ($api){

            $api->post('/','TemplateController@create')->where('app_id', '[0-9]+');

            $api->put('/{template_id}', 'TemplateController@update')->where(array(
                'app_id' => '[0-9]+',
                'template_id' => '[0-9]+',
            ));

            $api->delete('/{template_id}', 'TemplateController@delete')->where(array(
                'app_id' => '[0-9]+',
                'template_id' => '[0-9]+',
            ));

            $api->get('/{template_id}', 'TemplateController@getItem')->where(array(
                'app_id' => '[0-9]+',
                'template_id' => '[0-9]+',
            ));

            $api->get('/', 'TemplateController@getList')->where(array(
                'app_id' => '[0-9]+',
                'template_id' => '[0-9]+',
            ));

        });

    });

});