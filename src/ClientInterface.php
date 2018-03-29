<?php
declare(strict_types=1);
/**
 * @link https://github.com/codenix-sv/bitfinex-api-ws
 * @copyright Copyright (c) 2018 codenix-sv
 * @license https://github.com/codenix-sv/bitfinex-api-ws/blob/master/LICENSE
 */

namespace codenixsv\BitfinexWs;

/**
 * Interface ClientInterface
 * @package codenixsv\BitfinexWs
 */
interface ClientInterface
{
    /**
     * @param array $request
     * @param callable $onMessage
     * @param callable $onClose
     * @param callable $onException
     */
    public function makeWebSocketRequest(array $request, callable $onMessage, callable $onClose, callable $onException);
}
