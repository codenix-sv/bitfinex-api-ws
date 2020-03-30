<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeBooks;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeBooksTest extends TestCase
{
    public function testGetFrame()
    {
        $symbol = 'tBTCUSD';
        $precision = 'P1';
        $frequency = 'F1';
        $length = "100";

        $request = new SubscribeBooks($symbol, $precision, $frequency, $length);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $symbol = 'tBTCUSD';
        $precision = 'P1';
        $frequency = 'F1';
        $length = "100";

        $request = new SubscribeBooks($symbol, $precision, $frequency, $length);
        $expected = '{"event":"subscribe","channel":"book","symbol":"tBTCUSD","prec":"P1","freq":"F1","len":"100"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $symbol = 'tBTCUSD';
        $precision = 'P1';
        $frequency = 'F1';
        $length = "100";

        $request = new SubscribeBooks($symbol, $precision, $frequency, $length);

        $expected = [
            'event' => 'subscribe',
            'channel' => 'book',
            'symbol' => $symbol,
            'prec' => $precision,
            'freq' => $frequency,
            'len' => $length
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
