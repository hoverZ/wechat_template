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

    $api->group(['prefix' => 'auth', 'namespace' => 'App\Http\Controllers\Auth'],function ($api){

        $api->post('/user', 'RegisterController@createUser');

        $api->post('/', 'AuthenticateController@authenticate');

    });

    $api->group([ 'prefix' => 'user', 'namespace' => 'App\Http\Controllers', 'middleware' => 'jwt.auth'], function($api){

        $api->get('/', 'UserOperationController@getUser');

        $api->group( ['prefix' => '{user_id}/apps'], function($api){

            $api->post('/','AppController@create')->where('user_id', '[0-9]+');

            $api->put('/{app_id}', 'AppController@update')->where(array(
                'app_id' => '[0-9]+',
                'user_id' => '[0-9]+',
            ));

            $api->delete('/{app_id}', 'AppController@delete')->where(array(
                'app_id' => '[0-9]+',
                'user_id' => '[0-9]+',
            ));

            $api->get('/{app_id}', 'AppController@getItem')->where(array(
                'app_id' => '[0-9]+',
                'user_id' => '[0-9]+',
            ));

            $api->get('/', 'AppController@getList')->where('user_id', '[0-9]+');

            $api->group([ 'prefix' => '{app_id}/template'], function ($api){

                $api->post('/','TemplateController@create')->where(array(
                    'app_id' => '[0-9]+',
                    'user_id' => '[0-9]+',
                ));

                $api->put('/{template_id}', 'TemplateController@update')->where(array(
                    'app_id' => '[0-9]+',
                    'template_id' => '[0-9]+',
                    'user_id' => '[0-9]+',
                ));

                $api->delete('/{template_id}', 'TemplateController@delete')->where(array(
                    'app_id' => '[0-9]+',
                    'template_id' => '[0-9]+',
                    'user_id' => '[0-9]+',
                ));

                $api->get('/{template_id}', 'TemplateController@getItem')->where(array(
                    'app_id' => '[0-9]+',
                    'template_id' => '[0-9]+',
                    'user_id' => '[0-9]+',
                ));

                $api->get('/', 'TemplateController@getList')->where(array(
                    'app_id' => '[0-9]+',
                    'template_id' => '[0-9]+',
                    'user_id' => '[0-9]+',
                ));

            });

        });

    });

    $api->group(['prefix' => 'client', 'namespace' => 'App\Http\Controllers'],function ($api){

        $api->group([ 'prefix' => 'wechat/apps/{token}'], function ($api){

            $api->post('/industry', 'ClientOperationController@setIndustryByToken');

            $api->get('/industry', 'ClientOperationController@getIndustryByToken');

            $api->post('/templates', 'ClientOperationController@addTemplateByToken');

            $api->get('/templates/send/{template_data}', 'ClientOperationController@sendTemplateByToken');

            $api->get('/templates', 'ClientOperationController@getPrivateTemplatesByToken');

            $api->delete('/templates/{template_id}', 'ClientOperationController@deletePrivateTemplateByToken');

        });

        $api->group([ 'prefix' => 'wechat/apps/{app_id}/{secret}'], function ($api){

            $api->post('/industry', 'ClientOperationController@setIndustryByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/industry', 'ClientOperationController@getIndustryByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->post('/templates', 'ClientOperationController@addTemplateByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/templates/send/{template_data}', 'ClientOperationController@sendTemplateByClient')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->get('/templates', 'ClientOperationController@getPrivateTemplates')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+'
            ));

            $api->delete('/templates/{template_id}', 'ClientOperationController@deletePrivateTemplate')->where(array(
                'app_id' => '[0-9a-z_A-z]+',
                'secret' => '[0-9a-z_A-z]+',
            ));

        });

    });



});