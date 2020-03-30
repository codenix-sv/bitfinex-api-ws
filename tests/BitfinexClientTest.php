<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Test;

use Codenixsv\BitfinexWs\BaseWsClient;
use Codenixsv\BitfinexWs\BitfinexClient;
use Codenixsv\BitfinexWs\Request\Request;
use PHPUnit\Framework\TestCase;
use Ratchet\RFC6455\Messaging\Message;

class BitfinexClientTest extends TestCase
{
    public function testConnect()
    {
        $wsClient = $this->getMockBuilder(BaseWsClient::class)->getMock();
        $client = new BitfinexClient($wsClient);

        $wsClient->expects($this->once())
            ->method('connect')
            ->withConsecutive([
                $this->isType('string'),
                $this->isInstanceOf(Message::class),
                $this->isType('array'),
                $this->isType('callable'),
            ]);

        $client->connect([], []);
    }

    public function testConnectWithRequest()
    {
        $wsClient = $this->getMockBuilder(BaseWsClient::class)->getMock();
        $client = new BitfinexClient($wsClient);

        $request = $this->getMockBuilder(Request::class)->getMock();
        $request->expects($this->once())->method('getFrame');

        $client->connect([$request], []);
    }

    public function testAuthConnect()
    {
        $wsClient = $this->getMockBuilder(BaseWsClient::class)->getMock();
        $client = new BitfinexClient($wsClient);

        $wsClient->expects($this->once())
            ->method('connect')
            ->withConsecutive([
                $this->isType('string'),
                $this->isInstanceOf(Message::class),
                $this->isType('array'),
                $this->isType('callable'),
            ]);

        $client->authConnect([], []);
    }

    public function testGetOnReject()
    {
        $client = new BitfinexClient();

        $this->assertIsCallable($client->getOnReject());
    }

    public function testGetOnRejectOutput()
    {
        $client = new BitfinexClient();
        $onReject = $client->getOnReject();

        $this->expectOutputString('test');

        $onReject(new \Exception('test'));
    }
}
