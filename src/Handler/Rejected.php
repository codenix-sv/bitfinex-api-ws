<?php

declare(strict_types=1);

namespace Codenixsv\BitfinexWs\Handler;

use Exception;
use React\EventLoop\LoopInterface;

/**
 * Class Rejected
 * @package Codenixsv\BitfinexWs\Handler
 */
class Rejected
{
    /** @var LoopInterface */
    private $loop;

    /** @var callable */
    private $handler;

    /**
     * Rejected constructor.
     * @param LoopInterface $loop
     * @param callable $handler
     */
    public function __construct(LoopInterface $loop, callable $handler)
    {
        $this->loop = $loop;
        $this->handler = $handler;
    }

    /**
     * @param Exception $exception
     */
    public function __invoke(Exception $exception)
    {
        call_user_func($this->handler, $exception);
        $this->loop->stop();
    }
}
