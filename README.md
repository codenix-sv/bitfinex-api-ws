# bitfinex-api-ws

[![Build Status](https://travis-ci.com/codenix-sv/bitfinex-api-ws.svg?branch=master)](https://travis-ci.com/codenix-sv/bitfinex-api-ws)
[![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/codenix-sv/bitfinex-api-ws/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/codenix-sv/bitfinex-api-ws/?branch=master)
[![Test Coverage](https://api.codeclimate.com/v1/badges/3b14372b014ab37bd848/test_coverage)](https://codeclimate.com/github/codenix-sv/bitfinex-api-ws/test_coverage)
[![Maintainability](https://api.codeclimate.com/v1/badges/3b14372b014ab37bd848/maintainability)](https://codeclimate.com/github/codenix-sv/bitfinex-api-ws/maintainability)
[![License: MIT](https://img.shields.io/github/license/codenix-sv/bitfinex-api-ws)](https://github.com/codenix-sv/bitfinex-api-ws/blob/master/LICENSE)

WebSocket client, written with PHP for [bitfinex.com](https://www.bitfinex.com) API.

Bitfinex is a full-featured spot trading platform for major digital assets & cryptocurrencies, including Bitcoin, Ethereum, EOS, Litecoin, Ripple, NEO, Monero and many more. Bitfinex offers leveraged margin trading through a peer-to-peer funding market, allowing users to securely trade with up to 3.3x leverage.

For additional information about API visit [docs.bitfinex.com/docs/ws-general](https://docs.bitfinex.com/docs/ws-general)

## Requirements

* PHP >= 7.3
* ext-json

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```bash
$ composer require codenix-sv/bitfinex-api-ws
```
or add

```json
"codenix-sv/bitfinex-api-ws": "^0.1"
```
## Basic usage

### Example
```php
use Codenixsv\BitfinexWs\BitfinexClient;
use Codenixsv\BitfinexWs\WsClient;
use Codenixsv\BitfinexWs\Request\SubscribeTicker;
use Ratchet\RFC6455\Messaging\Message;

$client = new BitfinexClient();

$onMessage = function (Message $message) {
    echo $message->__toString() . PHP_EOL;
};

$onClose = function ($code = null, $reason = null) {
    echo 'WebSocket Connection closed! Code: ' . $code . ' Reason: ' . $reason  . PHP_EOL;
};

$onError = function (\Exception $e) {
    echo 'Error: ' . $e->getMessage() . PHP_EOL;
};

$events =  [
    WsClient::EVENT_MESSAGE => $onMessage,
    WsClient::EVENT_CLOSE => $onClose,
    WsClient::EVENT_ERROR => $onError
];

$client->connect([new SubscribeTicker('tBTCUSD'), new SubscribeTicker('tETHUSD')], $events);
```

## Available channels

### Public

#### [SubscribeTicker](https://docs.bitfinex.com/reference#ws-public-ticker)

The ticker endpoint provides a high level overview of the state of the market for a specified pair. It shows the current best bid and ask, the last traded price, as well as information on the daily volume and price movement over the last day.
```php
$client->connect([new SubscribeTicker('tBTCUSD')], $events);
```

#### [SubscribeTrades](https://docs.bitfinex.com/reference#ws-public-trades)

This channel sends a trade message whenever a trade occurs at Bitfinex. It includes all the pertinent details of the trade, such as price, size and the time of execution. The channel can send funding trade data as well.
```php
$client->connect([new SubscribeTrades('tBTCUSD')], $events);
```

#### [SubscribeBooks](https://docs.bitfinex.com/reference#ws-public-books)

The Order Books channel allows you to keep track of the state of the Bitfinex order book. It is provided on a price aggregated basis with customizable precision. Upon connecting, you will receive a snapshot of the book followed by updates for any changes to the state of the book.
```php
$symbol = 'tBTCUSD';
$precision = 'P1';
$frequency = 'F1';
$length = '100';

$client->connect([new SubscribeBooks($symbol, $precision, $frequency, $length)], $events);
```

#### [SubscribeRawBooks](https://docs.bitfinex.com/reference#ws-public-raw-books)

The Raw Books channel provides the most granular books.
```php
$symbol = 'tBTCUSD';
$length = '100';

$client->connect([new SubscribeRawBooks($symbol, $length)], $events);
```

#### [SubscribeCandles](https://docs.bitfinex.com/reference#ws-public-candles)

The Candles endpoint provides OCHL (Open, Close, High, Low) and volume data for the specified trading pair.
```php
$client->connect([new SubscribeCandles('trade:1m:tBTCUSD')], $events);
```

#### [SubscribeCandles](https://docs.bitfinex.com/reference#ws-public-status)

Subscribe to and receive different types of platform information - currently supports derivatives pair status and liquidation feed.
```php
$client->connect([new SubscribeStatus('deriv:tBTCF0:USTF0')], $events);
```

## License

`codenix-sv/bitfinex-api-ws` is released under the MIT License. See the bundled [LICENSE](./LICENSE) for details.