<?php
declare(strict_types=1);
/**
 * @link https://github.com/codenix-sv/bitfinex-api-ws
 * @copyright Copyright (c) 2018 codenix-sv
 * @license https://github.com/codenix-sv/bitfinex-api-ws/blob/master/LICENSE
 */

namespace codenixsv\BitfinexWs;


/**+
 * Class BitfinexClient
 * @package codenixsv\BitfinexWs
 */
class BitfinexClient extends Client
{
    /**
     * @var callable
     */
    private $onClose;

    /**
     * @var callable
     */
    private $onException;

    /**
     * BitfinexClient constructor.
     * @param string $uri
     */
    public function __construct(string $uri)
    {
        parent::__construct($uri);

        $this->onClose = function($code = null, $reason = null) {
            echo "WebSocket Connection closed! ({$code} - {$reason})" . PHP_EOL;
        };

        $this->onException = function(\Exception $e) {
            echo "Could not connect: {$e->getMessage()}" . PHP_EOL;
        };
    }

    /**
     * The ticker is a high level overview of the state of the market.
     * It shows you the current best bid and ask, as well as the last trade price.
     * It also includes information such as daily volume and how much the price has moved over the last day.
     * @see https://bitfinex.readme.io/v1/reference#ws-public-ticker
     *
     * @param string $pair
     * @param callable $onMessage
     */
    public function ticker(string $pair, callable $onMessage)
    {
        $requestData = [
            'event' => 'subscribe',
            'channel' => 'ticker',
            'pair' => $pair
        ];

        $this->makeWebsocketRequest($requestData, $onMessage, $this->onClose, $this->onException);
    }

    /**
     * This channel sends a trade message whenever a trade occurs at Bitfinex.
     * It includes all the pertinent details of the trade, such as price, size and time.
     * @see https://bitfinex.readme.io/v1/reference#ws-public-trades
     *
     * @param string $pair
     * @param callable $onMessage
     */
    public function trades(string $pair, callable $onMessage)
    {
        $requestData = [
            'event' => 'subscribe',
            'channel' => 'trades',
            'pair' => $pair
        ];

        $this->makeWebsocketRequest($requestData, $onMessage, $this->onClose, $this->onException);
    }

    /**
     * The Order Books channel allow you to keep track of the state of the Bitfinex order book.
     * It is provided on a price aggregated basis, with customizable precision.
     * After receiving the response, you will receive a snapshot of the book,
     * followed by updates upon any changes to the book.
     * @see https://bitfinex.readme.io/v1/reference#ws-public-order-books
     *
     * @param string $pair
     * @param string $precision
     * @param callable $onMessage
     */
    public function orderBooks(string $pair, string $precision, callable $onMessage)
    {
        $requestData = [
            'event' => 'subscribe',
            'channel' => 'book',
            'prec' => $precision,
            'pair' => $pair
        ];

        $this->makeWebsocketRequest($requestData, $onMessage, $this->onClose, $this->onException);
    }

    /**
     * These are the most granular books.
     * @see https://bitfinex.readme.io/v1/reference#ws-public-raw-order-books
     *
     * @param string $pair
     * @param callable $onMessage
     */
    public function rawOrderBooks(string $pair, callable $onMessage)
    {
        $requestData = [
            'event' => 'subscribe',
            'channel' => 'book',
            'prec' => 'R0',
            'pair' => $pair
        ];

        $this->makeWebsocketRequest($requestData, $onMessage, $this->onClose, $this->onException);
    }
}
