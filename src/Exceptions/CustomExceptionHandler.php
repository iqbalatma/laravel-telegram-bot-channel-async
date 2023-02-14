<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\Exceptions;

use App\Exceptions\Handler;
use Illuminate\Support\Arr;
use Illuminate\Support\Reflector;
use Iqbalatma\LaravelTelegramBotChannelAsync\Log;
use Psr\Log\LogLevel;
use Throwable;

class CustomExceptionHandler extends Handler
{
    public function report(Throwable $e)
    {
        $e = $this->mapException($e);


        if ($this->shouldntReport($e)) {
            return;
        }

        if (
            Reflector::isCallable($reportCallable = [$e, 'report']) &&
            $this->container->call($reportCallable) !== false
        ) {
            return;
        }

        foreach ($this->reportCallbacks as $reportCallback) {
            if ($reportCallback->handles($e) && $reportCallback($e) === false) {
                return;
            }
        }

        $level = Arr::first(
            $this->levels,
            fn ($level, $type) => $e instanceof $type,
            LogLevel::ERROR
        );


        Log::{$level}(
            $e->getMessage(),
            $this->getFormattedException($e)
        );
    }

    private function getFormattedException(Throwable $e)
    {
        return array_merge(
            $this->exceptionContext($e),
            $this->context(),
            [
                "exception" => array_merge(get_object_vars($e), [
                    "code" => $e->getCode(),
                    "file" => $e->getFile(),
                    "line" => $e->getLine(),
                    "trace" => $e->getTraceAsString()
                ])
            ]
        );
    }
}
