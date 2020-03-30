<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Handler;

use Codenixsv\BitfinexWs\Handler\Rejected;
use PHPUnit\Framework\TestCase;
use React\EventLoop\LoopInterface;

class RejectedTest extends TestCase
{
    public function testInvoke()
    {
        $callback = function () {
        };
        $loop = $this->getMockBuilder(LoopInterface::class)->getMock();
        $handler = new Rejected($loop, $callback);

        $loop->expects($this->once())->method('stop');

        $handler->__invoke(new \Exception('test'));
    }
}
