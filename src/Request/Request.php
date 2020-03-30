<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Request;

use Ratchet\RFC6455\Messaging\Frame;

/**
 * Interface Request
 * @package Codenixsv\BitfinexWs\Request
 */
interface Request
{
    /**
     * @return Frame
     */
    public function getFrame(): Frame;
}
