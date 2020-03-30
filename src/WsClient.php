<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs;

use Codenixsv\BitfinexWs\Handler\Fulfilled;
use Codenixsv\BitfinexWs\Handler\Rejected;
use Ratchet\RFC6455\Messaging\Message;
use Ratchet\Client\Connector;
use React\EventLoop\Factory;
use React\EventLoop\LoopInterface;
use React\Socket\Connector as ReactConnector;
use React\Promise\PromiseInterface;

/**
 * Class WsClient
 * @package Codenixsv\BitfinexWs
 */
class WsClient implements BaseWsClient
{
    public const EVENT_MESSAGE = 'message';
    public const EVENT_CLOSE = 'close';
    public const EVENT_ERROR = 'error';

    /** @var LoopInterface */
    private $loop;

    /** @var Connector  */
    private $connector;

    /**
     * WsClient constructor.
     * @param string $dns
     * @param int $timeout
     * @param LoopInterface|null $loop
     */
    public function __construct(string $dns = '8.8.8.8', int $timeout = 10, ?LoopInterface $loop = null)
    {
        $this->loop = $loop ?: Factory::create();
        $this->connector = $this->createConnector($this->loop, $dns, $timeout);
    }

    /**
     * @param string $url
     * @param Message $message
     * @param array $events
     * @param callable $onRejected
     */
    public function connect(string $url, Message $message, array $events, callable $onRejected): void
    {
        $promise = $this->connector($url);

        $onFulfilled = new Fulfilled($message, $events);
        $onRejected = new Rejected($this->loop, $onRejected);

        $promise->then($onFulfilled, $onRejected);

        $this->loop->run();
    }


    /**
     * @param $url
     * @return PromiseInterface
     */
    private function connector($url): PromiseInterface
    {
        $connector = $this->connector;

        return $connector($url);
    }

    /**
     * @param LoopInterface $loop
     * @param string $dns
     * @param int $timeout
     * @return Connector
     */
    private function createConnector(LoopInterface $loop, string $dns, int $timeout): Connector
    {
        $reactConnector = new ReactConnector($loop, [
            'dns' => $dns,
            'timeout' => $timeout
        ]);

        return new Connector($loop, $reactConnector);
    }
}
