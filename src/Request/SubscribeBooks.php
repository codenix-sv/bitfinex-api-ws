<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Class SubscribeBooks
 * @package Codenixsv\BitfinexWs\Request
 */
class SubscribeBooks implements Request
{
    /** @var string */
    private $symbol;

    /** @var string */
    private $precision;

    /** @var string */
    private $frequency;

    /** @var string */
    private $length;

    /**
     * SubscribeBooks constructor.
     * @param string $symbol
     * @param string $precision
     * @param string $frequency
     * @param string $length
     */
    public function __construct(string $symbol, string $precision, string $frequency, string $length)
    {
        $this->symbol = $symbol;
        $this->precision = $precision;
        $this->frequency = $frequency;
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
            'prec' => $this->precision,
            'freq' => $this->frequency,
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
