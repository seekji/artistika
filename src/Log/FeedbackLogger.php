<?php

namespace App\Log;

use Psr\Log\LoggerInterface;

/**
 * Class FeedbackLogger
 * @package App\Log
 */
class FeedbackLogger
{
    /**
     * @var LoggerInterface
     */
    private $logger;

    /**
     * LoggerService constructor.
     * @param LoggerInterface $logger
     */
    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function log($level, $message)
    {
        $this->logger->log($level, $message);
    }
}