<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\TelegramLogs;

use GuzzleHttp\Client;
use Monolog\Formatter\FormatterInterface;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\HandlerInterface;
use Monolog\Utils;

class TelegramBotHandler extends AbstractProcessingHandler implements HandlerInterface
{
    private const BASE_URL = 'https://api.telegram.org/bot';
    private const PARSE_MODE = "html";
    private const MAX_MESSAGE_LENGTH = 4096;
    private string $apiKey;
    private string $channelId;
    private bool $splitLongMessages;
    /**
     */
    public function __construct(string $api_key, string $channel_id, bool $splitLongMessages)
    {
        $this->apiKey = $api_key;
        $this->channelId = $channel_id;
        $this->splitLongMessages = $splitLongMessages;
    }
    /**
     * Writes the record down to the log of the implementing handler
     *
     */
    protected function write(array $record): void
    {
        $messages = $this->handleMessageLength($record["formatted"]);

        foreach ($messages as $key => $msg) {
            $this->send($msg);
            sleep(1);
        }
    }

    private function send($message)
    {
        try {
            $httpClient = new Client();
            $url = self::BASE_URL . $this->apiKey . '/SendMessage';

            $options = [
                'form_params' => [
                    'text' => $message,
                    'chat_id' => $this->channelId,
                    'parse_mode' => self::PARSE_MODE,
                    'disable_web_page_preview' => true,
                ]
            ];

            $httpClient->post($url, $options);
        } catch (\Exception $e) {
        }
    }

    public function handleMessageLength(string $message)
    {
        $truncatedMarker = ' (...truncated)';
        // if the message is not split but more than MAX_MESSAGE_LENGTH, add truncated.
        // return as array so they can be loop
        if (!$this->splitLongMessages && strlen($message) > self::MAX_MESSAGE_LENGTH) {
            return [Utils::substr($message, 0, self::MAX_MESSAGE_LENGTH - strlen($truncatedMarker)) . $truncatedMarker];
        }

        return str_split($message, self::MAX_MESSAGE_LENGTH);
    }

    public function getDefaultFormatter(): FormatterInterface
    {
        return new TelegramFormatter();
    }
}
