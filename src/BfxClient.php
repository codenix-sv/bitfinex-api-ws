<?php
declare(strict_types=1);
/**
 * @link https://github.com/codenix-sv/bitfinex-api-ws
 * @copyright Copyright (c) 2018 codenix-sv
 * @license https://github.com/codenix-sv/bitfinex-api-ws/blob/master/LICENSE
 */

namespace codenixsv\BitfinexWs;

use React\EventLoop\Factory;
use React\Socket\Connector;
use Ratchet\Client\Connector as ClientConnector;
use Ratchet\RFC6455\Messaging\MessageInterface;
use Ratchet\Client\WebSocket;

/**
 * Class BfxClient
 * @package codenixsv\BitfinexWs
 */
class BfxClient
{
    const URI = 'wss://api.bitfinex.com/ws';

    private function makeWebSocketRequest($request, $onMessage, $onClose, $onException)
    {
        $loop = Factory::create();
        $reactConnector = new Connector($loop);
        $connector = new ClientConnector($loop, $reactConnector);

        $connector(self::URI)
            ->then(function(WebSocket $conn) use ($request, $onMessage, $onClose, $onException) {

                $conn->on('message', function(MessageInterface $msg) use ($conn, $onMessage) {
                    call_user_func($onMessage, $msg);
                });

                $conn->on('close', function($code = null, $reason = null) use ($conn, $onClose) {
                    if (is_callable($onClose)) {
                        call_user_func($onClose, $code, $reason);
                    }
                });

                $data = json_encode($request);
                $conn->send($data);

            }, function(\Exception $e) use ($loop, $onException) {
                if (is_callable($onException)) {
                    call_user_func($onException, $e);
                }
                $loop->stop();
            });

        $loop->run();
    }

    public function ticker($pair, callable $onMessage, $onClose = null, $onException = null)
    {
        $requestData = [
            'event' => 'subscribe',
            'channel' => 'ticker',
            'pair' => $pair
        ];

        $this->makeWebsocketRequest($requestData, $onMessage, $onClose, $onException);
    }
}
