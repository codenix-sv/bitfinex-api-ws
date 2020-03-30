<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeCandles;
use Codenixsv\BitfinexWs\Request\SubscribeTicker;
use Codenixsv\BitfinexWs\Request\SubscribeTrades;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeCandlesTest extends TestCase
{
    public function testGetFrame()
    {
        $key = 'trade:1m:tBTCUSD';
        $request = new SubscribeCandles($key);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $key = 'trade:1m:tBTCUSD';
        $request = new SubscribeCandles($key);
        $expected = '{"event":"subscribe","channel":"candles","key":"trade:1m:tBTCUSD"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $key = 'trade:1m:tBTCUSD';
        $request = new SubscribeCandles('trade:1m:tBTCUSD');

        $expected = [
            'event' => 'subscribe',
            'channel' => 'candles',
            'key' => $key,
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
