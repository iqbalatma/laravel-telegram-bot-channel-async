<?php

namespace Iqbalatma\LaravelTelegramBotChannelAsync\TelegramLogs;

use Monolog\Formatter\FormatterInterface;
use Monolog\Formatter\LineFormatter;

class TelegramFormatter extends AbstractTelegramFormatter implements FormatterInterface
{
    public function __construct(string|null $format = null, string|null $dateFormat = null)
    {
        parent::__construct($format, $dateFormat);
    }
    /**
     * Formats a log record.
     *
     * @param array $record A record to format
     * @return mixed The formatted record
     */
    public function format(array $record)
    {
        return parent::getMessageForLog($record);
    }


    /**
     * Formats a set of log records.
     *
     * @param array $records A set of records to format
     * @return mixed The formatted set of records
     */
    public function formatBatch(array $records)
    {
    }
}
