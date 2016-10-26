<?php

namespace App\Jobs;

use App\Models\App;
use App\Services\WechatService;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class SendTemplate implements ShouldQueue
{
    use InteractsWithQueue, Queueable, SerializesModels;

    private $app;
    private $template_data;
    /**
     * Create a new job instance.
     * @param $app
     * @param $template_data
     */
    public function __construct( App $app, $template_data)
    {
        $this->app = $app;
        $this->template_data = $template_data;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        WechatService::noticeOperationByApp($this->app->appid, $this->app->secret,
            WechatService::TEMPLATE_SEND, $this->template_data);
    }
}
