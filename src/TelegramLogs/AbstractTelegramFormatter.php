<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\TelegramLogs;

use Exception;

abstract class AbstractTelegramFormatter
{
    private const MESSAGE_FORMAT = "<b>%level_name%</b> (%channel%) [%date%]\n\n%message%\n\n%context%%extra%%exception%";
    private const DATE_FORMAT = 'Y-m-d H:i:s e';
    private string $format;
    private string $dateFormat;
    public function __construct(string|null $format = null, string|null $dateFormat = null)
    {
        $this->format = $format ?? self::MESSAGE_FORMAT;
        $this->dateFormat = $dateFormat ?? self::DATE_FORMAT;
    }
    protected function getMessageForLog($record)
    {
        $message = $this->format;
        if (strpos($record['message'], 'Stack trace') !== false) {
            // Replace '<' and '>' with their special codes
            $record['message'] = preg_replace('/<([^<]+)>/', '&lt;$1&gt;', $record['message']);

            // Put the stack trace inside <code></code> tags
            $record['message'] = preg_replace('/^Stack trace:\n((^#\d.*\n?)*)$/m', "\n<b>Stack trace:</b>\n<code>$1</code>", $record['message']);
        }

        $message = str_replace('%message%', $record['message'], $message);

        $this->formatMessageData($record, $message);
        $this->formatContextData($record, $message);
        $this->formatExtraData($record, $message);
        $this->formatExceptionData($record, $message);

        return $message;
    }

    private function formatMessageData(array $record, string &$message): void
    {
        $message = str_replace(
            ['%level_name%', '%channel%', '%date%'],
            [$record['level_name'], $record['channel'], $record['datetime']->format($this->dateFormat)],
            $message
        );
    }
    private function formatExtraData(array $record, string &$message): void
    {
        if ($record['context']["extra"]) {
            $extra = "<b>Extra:</b> \n";
            foreach ($record["context"]["extra"] as $key => $value) {
                if ($value) { //to prevent null value
                    $extra .= "\t$key : $value\n";
                }
            }
            $message = str_replace('%extra%', $extra . "\n", $message);
        } else {
            $message = str_replace('%extra%', '', $message);
        }
    }

    private function formatContextData(array $record, string &$message): void
    {
        try {
            if ($record['context']) {
                $context = "<b>Context:</b> \n";
                foreach ($record["context"] as $key => $value) {
                    if ($key == "exception" || $key == "extra") continue;

                    if ($value)
                        $context .= "\t$key : $value\n";
                }

                $message = str_replace('%context%', $context . "\n", $message);
            } else {
                $message = str_replace('%context%', '', $message);
            }
        } catch (Exception $e) {
        }
    }

    public function formatExceptionData(array $record, string &$message): void
    {
        try {
            if (isset($record["context"]["exception"])) {
                $exception = "<b>Exception :</b> \n";
                foreach ($record["context"]["exception"] as $key => $value) {
                    $exception .= "\t$key : $value\n";
                }
                $message = str_replace('%exception%', $exception . "\n", $message);
            } else {
                $message = str_replace('%exception%', '', $message);
            }
        } catch (Exception $e) {
        }
    }
}
