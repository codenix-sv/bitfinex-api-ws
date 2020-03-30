<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test;

use Codenixsv\BitfinexWs\Handler\Fulfilled;
use Codenixsv\BitfinexWs\Handler\Rejected;
use Codenixsv\BitfinexWs\WsClient;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\Message;
use React\EventLoop\LoopInterface;
use React\Promise\PromiseInterface;

class WsClientTest extends TestCase
{
    public function testConnect()
    {
        $url = 'wss://api-pub.bitfinex.com/ws/2';
        $loop = $this->getMockBuilder(LoopInterface::class)
            ->getMock();
        $client = new WsClient('8.8.8.8', 10, $loop);

        $loop->expects($this->once())->method('run');

        $client->connect($url, new Message(), [], function () {
        });
    }
}
