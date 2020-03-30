<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Class SubscribeTicker
 * @package Codenixsv\BitfinexWs\Request
 */
class SubscribeTicker implements Request
{
    /** @var string */
    private $symbol;

    /**
     * Ticker constructor.
     * @param string $symbol
     */
    public function __construct(string $symbol)
    {
        $this->symbol = $symbol;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return [
            'event' => 'subscribe',
            'channel' => 'ticker',
            'symbol' => $this->symbol
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
