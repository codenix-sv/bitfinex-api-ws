<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs;

use Codenixsv\BitfinexWs\Request\Request;
use Exception;
use Ratchet\RFC6455\Messaging\Message;

/**
 * Class BitfinexClient
 * @package Codenixsv\BitfinexWs
 */
class BitfinexClient
{
    private const PUBLIC_CHANNELS_URL = 'wss://api-pub.bitfinex.com/ws/2';
    private const AUTHENTICATED_CHANNELS_URL = 'wss://api.bitfinex.com/ws/2';

    /** @var BaseWsClient */
    private $client;

    /** @var callable */
    private $onReject;

    /**
     * BitfinexClient constructor.
     * @param BaseWsClient|null $client
     */
    public function __construct(?BaseWsClient $client = null)
    {
        $this->client = $client ?: new WsClient();

        $this->onReject = static function (Exception $exception) {
            echo $exception->getMessage();
        };
    }

    /**
     * @param Request[] $requests
     * @param array $events
     */
    public function connect(array $requests, array $events)
    {
        $this->client->connect(
            $this->getPublicChannelsUrl(),
            $this->createMessage($requests),
            $events,
            $this->onReject
        );
    }

    /**
     * @param array $requests
     * @param array $events
     */
    public function authConnect(array $requests, array $events)
    {
        $this->client->connect(
            $this->getAuthenticatedChannelsUrl(),
            $this->createMessage($requests),
            $events,
            $this->onReject
        );
    }

    /**
     * @return string
     */
    public function getPublicChannelsUrl(): string
    {
        return self::PUBLIC_CHANNELS_URL;
    }

    /**
     * @return string
     */
    public function getAuthenticatedChannelsUrl(): string
    {
        return self::AUTHENTICATED_CHANNELS_URL;
    }

    public function getOnReject(): callable
    {
        return $this->onReject;
    }

    /**
     * @param Request[] $requests
     * @return Message
     */
    private function createMessage(array $requests): Message
    {
        $message = new Message();

        foreach ($requests as $request) {
            $message->addFrame($request->getFrame());
        }

        return $message;
    }
}
