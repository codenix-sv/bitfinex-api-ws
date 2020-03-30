<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Class SubscribeCandles
 * @package Codenixsv\BitfinexWs\Request
 */
class SubscribeCandles implements Request
{
    /** @var string */
    private $key;

    /**
     * SubscribeCandles constructor.
     * @param string $key
     */
    public function __construct(string $key)
    {
        $this->key = $key;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return [
            'event' => 'subscribe',
            'channel' => 'candles',
            'key' => $this->key
        ];
    }

    /**
     * @return Frame
     */
    public function getFrame(): Frame
    {
        return new Frame(json_encode($this->getPayload()));
    }
}
