<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Class SubscribeRawBooks
 * @package Codenixsv\BitfinexWs\Request
 */
class SubscribeRawBooks implements Request
{
    private const PRECISION = 'P0';

    /** @var string */
    private $symbol;

    /** @var string */
    private $length;

    /**
     * SubscribeRawBooks constructor.
     * @param string $symbol
     * @param string $length
     */
    public function __construct(string $symbol, string $length)
    {
        $this->symbol = $symbol;
        $this->length = $length;
    }

    /**
     * @return array
     */
    public function getPayload(): array
    {
        return [
            'event' => 'subscribe',
            'channel' => 'book',
            'symbol' => $this->symbol,
            'prec' => self::PRECISION,
            'len' => $this->length,

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
