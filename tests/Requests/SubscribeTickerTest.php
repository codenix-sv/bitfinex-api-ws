<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeTicker;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeTickerTest extends TestCase
{
    public function testGetFrame()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTicker($symbol);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTicker($symbol);
        $expected = '{"event":"subscribe","channel":"ticker","symbol":"tBTCUSD"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $symbol = 'tBTCUSD';
        $request = new SubscribeTicker('tBTCUSD');

        $expected = [
            'event' => 'subscribe',
            'channel' => 'ticker',
            'symbol' => $symbol,
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
