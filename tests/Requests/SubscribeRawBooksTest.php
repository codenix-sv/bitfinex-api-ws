<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test\Request;

use Codenixsv\BitfinexWs\Request\SubscribeRawBooks;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\FrameInterface;

class SubscribeRawBooksTest extends TestCase
{
    public function testGetFrame()
    {
        $symbol = 'tBTCUSD';
        $length = "100";

        $request = new SubscribeRawBooks($symbol, $length);

        $this->assertInstanceOf(FrameInterface::class, $request->getFrame());
    }

    public function testGetFramePayload()
    {
        $symbol = 'tBTCUSD';
        $length = "100";

        $request = new SubscribeRawBooks($symbol, $length);
        $expected = '{"event":"subscribe","channel":"book","symbol":"tBTCUSD","prec":"P0","len":"100"}';

        $this->assertEquals($expected, $request->getFrame()->getPayload());
    }

    public function testGetPayload()
    {
        $symbol = 'tBTCUSD';
        $precision = 'P0';
        $length = "100";

        $request = new SubscribeRawBooks($symbol, $length);

        $expected = [
            'event' => 'subscribe',
            'channel' => 'book',
            'symbol' => $symbol,
            'prec' => $precision,
            'len' => $length
        ];

        $this->assertEquals($expected, $request->getPayload());
    }
}
