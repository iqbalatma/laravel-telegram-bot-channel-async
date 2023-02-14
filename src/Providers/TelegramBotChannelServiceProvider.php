<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\Providers;

use Illuminate\Contracts\Debug\ExceptionHandler;
use Illuminate\Support\ServiceProvider;
use Iqbalatma\LaravelTelegramBotChannelAsync\Exceptions\CustomExceptionHandler;

class TelegramBotChannelServiceProvider extends ServiceProvider
{
    public function boot()
    {
    }

    public function register()
    {
        $this->app->singleton(ExceptionHandler::class, CustomExceptionHandler::class);
    }
}
