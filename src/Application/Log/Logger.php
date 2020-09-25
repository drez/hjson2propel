<?php

namespace App\Application\Log;

use Psr\Log\AbstractLogger;

class Logger extends AbstractLogger
{

    protected $logs;

    /**
     * Create a new multi logger instance.
     *
     * @param \Psr\Log\LoggerInterface[] $loggers
     *
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Log a message to the logs.
     *
     * @param string $level
     * @param mixed  $message
     * @param array  $context
     *
     * @return void
     */
    public function log($level, $message, array $context = [])
    {
        $this->logs[$level][] = $message;
    }

    public function getLog($level = 'all')
    {
        return $this->logs;
    }
}
