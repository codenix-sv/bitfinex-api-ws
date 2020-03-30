<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeTicker;
use Codenixsv\BitfinexWs\Request\SubscribeTrades;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeTradesTest extends TestCase
{
    public function testGetFrame()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTrades($symbol);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTrades($symbol);
        $expected = '{"event":"subscribe","channel":"trades","symbol":"tBTCUSD"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTrades('tBTCUSD');

        $expected = [
            'event' => 'subscribe',
            'channel' => 'trades',
            'symbol' => $symbol,
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
