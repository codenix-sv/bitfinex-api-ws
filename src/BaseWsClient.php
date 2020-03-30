<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs;

use Ratchet\RFC6455\Messaging\Message;

/**
 * Interface BaseWsClient
 * @package Codenixsv\BitfinexWs
 */
interface BaseWsClient
{
    public function connect(string $url, Message $message, array $events, callable $onRejected): void;
}
