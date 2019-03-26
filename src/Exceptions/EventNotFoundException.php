<?php

namespace Scaleplan\Event\Exceptions;

/**
 * Class EventNotFoundException
 *
 * @package Scaleplan\Event\Exceptions
 */
class EventNotFoundException extends AbstractException
{
    public const MESSAGE = 'Class :event not found.';

    /**
     * EventNotFoundException constructor.
     *
     * @param string $eventName
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $eventName, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = str_replace(':event', $eventName, static::MESSAGE);
    }
}
