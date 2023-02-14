<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync;

use Iqbalatma\LaravelTelegramBotChannelAsync\TelegramLogs\TelegramBotHandler;
use Monolog\Logger;

class TelegramLogger
{
    private string $apiKey;
    private string $channelId;
    private bool $splitLongMessages;
    public function __construct(string $apiKey, string $channelId, bool $splitLongMessages = false)
    {
        $this->apiKey = $apiKey;
        $this->channelId = $channelId;
        $this->splitLongMessages = $splitLongMessages;
    }
    public function __invoke()
    {
        $logger = new Logger("custom");
        $logger->pushHandler(new TelegramBotHandler($this->apiKey, $this->channelId, $this->splitLongMessages));

        return $logger;
    }
}
