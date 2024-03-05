<?php

namespace App\Services;

use Psr\Log\LoggerInterface;

class BaseService
{
    private ?LoggerInterface $logger = null;

    /**
     * @param LoggerInterface $logger
     * @return void
     */
    protected function setLogger(LoggerInterface $logger): void
    {
        $this->logger = $logger;
    }

    /**
     * @param string $message
     * @return void
     */
    protected function log(string $message): void
    {
        $this->logger?->info($message);
    }
}
