<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateAppsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('apps', function (Blueprint $table) {
            $table->increments('id');
            $table->string('appid',128);
            $table->string('secret',128);
            $table->integer('app_status')->default(1)->comment('1为可以使用,0为禁用');
            $table->integer('channel')->default(1)->comment('渠道,1 表示微信');
            $table->string('app_name', 128);
            $table->string('fail_call_back_url')->comment('发送模版消息反馈信息');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('apps');
    }
}
