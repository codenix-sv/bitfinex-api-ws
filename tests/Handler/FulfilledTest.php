<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Handler;

use Codenixsv\BitfinexWs\Handler\Fulfilled;
use PHPUnit\Framework\TestCase;
use Ratchet\Client\WebSocket;
use Ratchet\RFC6455\Messaging\Message;

class FulfilledTest extends TestCase
{
    public function testInvoke()
    {
        $event = 'close';
        $listener = function () {
        };
        $handler = new Fulfilled(new Message(), [$event => $listener]);

        $ws = $this->getMockBuilder(WebSocket::class)->disableOriginalConstructor()->getMock();

        $ws->expects($this->once())->method('send');
        $ws->expects($this->once())->method('removeAllListeners');
        $ws->expects($this->once())->method('on')->with($event, $listener);

        $handler->__invoke($ws);
    }
}
