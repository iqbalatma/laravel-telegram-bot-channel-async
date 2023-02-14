<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync;

use Iqbalatma\LaravelTelegramBotChannelAsync\Jobs\SendLogTelegramBotJob;

class Log
{
    public static function debug(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("debug", $message, $context));
    }
    public static function info(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("info", $message, $context));
    }
    public static function notice(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("notice", $message, $context));
    }
    public static function warning(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("warning", $message, $context));
    }
    public static function error(string $message, array $context): void
    {
        dispatch(new SendLogTelegramBotJob("error", $message, $context));
    }
    public static function critical(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("critical", $message, $context));
    }
    public static function emergency(string $message, array $context = []): void
    {
        dispatch(new SendLogTelegramBotJob("emergency", $message, $context));
    }
}
