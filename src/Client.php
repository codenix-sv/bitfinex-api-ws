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
 * Class Client
 * @package codenixsv\BitfinexWs
 */
class Client implements ClientInterface
{
    /**
     * @var string
     */
    private $uri;

    public function __construct(string $uri)
    {
        $this->uri = $uri;
    }

    /**
     * @param array $request
     * @param callable $onMessage
     * @param callable $onClose
     * @param callable $onException
     */
    public function makeWebSocketRequest(array $request, callable $onMessage, callable $onClose, callable $onException)
    {
        $loop = Factory::create();
        $reactConnector = new Connector($loop);
        $connector = new ClientConnector($loop, $reactConnector);

        $connector($this->uri)
            ->then(function(WebSocket $conn) use ($request, $onMessage, $onClose, $onException) {

                $conn->on('message', function(MessageInterface $msg) use ($conn, $onMessage) {
                    $data = json_decode($msg->getPayload());
                    call_user_func($onMessage, $data);
                });

                $conn->on('close', function($code = null, $reason = null) use ($conn, $onClose) {
                    call_user_func($onClose, $code, $reason);
                });

                $data = json_encode($request);
                $conn->send($data);

            }, function(\Exception $e) use ($loop, $onException) {
                call_user_func($onException, $e);
                $loop->stop();
            });

        $loop->run();
    }
}
