<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Class SubscribeTrades
 * @package Codenixsv\BitfinexWs\Request
 */
class SubscribeTrades implements Request
{
    /** @var string */
    private $symbol;

    /**
     * SubscribeTrades constructor.
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
            'channel' => 'trades',
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
