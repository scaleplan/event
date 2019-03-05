<?php

namespace Scaleplan\Event\Exceptions;

/**
 * Class AbstractException
 *
 * @package Scaleplan\Event\Exceptions
 */
class AbstractException extends \Exception
{
    public const MESSAGE = 'Event error.';

    /**
     * KafkaException constructor.
     *
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(\int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(static::MESSAGE, $code, $previous);
    }
}
