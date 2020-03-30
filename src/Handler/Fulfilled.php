<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Handler;

use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\Message;

/**
 * Class Fulfilled
 * @package Codenixsv\BitfinexWs\Handler
 */
class Fulfilled
{
    /** @var Message */
    private $message;

    /** @var array  */
    private $events;

    /**
     * Fulfilled constructor.
     * @param Message $message
     * @param array $events
     */
    public function __construct(Message $message, array $events)
    {
        $this->message = $message;
        $this->events = $events;
    }

    /**
     * @param WebSocket $webSocket
     */
    public function __invoke(WebSocket $webSocket)
    {
        $webSocket->removeAllListeners();

        foreach ($this->events as $event => $listener) {
            $this->registerListeners($webSocket, $event, $listener);
        }

        $webSocket->send($this->message);
    }

    /**
     * @param WebSocket $webSocket
     * @param string $event
     * @param callable $listener
     */
    private function registerListeners(WebSocket $webSocket, string $event, callable $listener)
    {
        $webSocket->on($event, $listener);
    }
}
