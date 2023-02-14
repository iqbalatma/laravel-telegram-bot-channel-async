<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class SendLogTelegramBotJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable;

    public string $type;
    public string $message;
    public array $context;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(string $type, string $message, array $context)
    {
        $request = [
            "extra" => [
                'user_id' => auth()->user() ? auth()->user()->id : NULL,
                'ip' => request()->server('REMOTE_ADDR'),
                'user_agent' => request()->server('HTTP_USER_AGENT'),
                'request_uri' => request()->getRequestUri(),
            ]
        ];

        $this->type = $type;
        $this->message = $message;
        $this->context = array_merge($request, $context);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Log::{$this->type}($this->message, $this->context);
    }
}
