<?php

namespace Scaleplan\Event\Exceptions;

use Scaleplan\Event\EventInterface;

/**
 * Class ClassIsNotEventException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassIsNotEventException extends AbstractException
{
    public const MESSAGE = 'Class :class must implements ' . EventInterface::class;

    /**
     * ClassIsNotEventException constructor.
     *
     * @param string $className
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $className, \int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = str_replace(':class', $className, static::MESSAGE);
    }
}
