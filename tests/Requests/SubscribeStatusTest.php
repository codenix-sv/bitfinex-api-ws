<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeStatus;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeStatusTest extends TestCase
{
    public function testGetFrame()
    {
        $key = 'deriv:tBTCF0:USTF0';
        $request = new SubscribeStatus($key);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $key = 'deriv:tBTCF0:USTF0';
        $request = new SubscribeStatus($key);
        $expected = '{"event":"subscribe","channel":"status","key":"deriv:tBTCF0:USTF0"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $key = 'deriv:tBTCF0:USTF0';
        $request = new SubscribeStatus('deriv:tBTCF0:USTF0');

        $expected = [
            'event' => 'subscribe',
            'channel' => 'status',
            'key' => $key,
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
