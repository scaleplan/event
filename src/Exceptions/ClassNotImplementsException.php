<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

/**
 * Class ClassNotImplementsException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassNotImplementsException extends AbstractException
{
    public const MESSAGE = 'Class :class must implements required interface.';
    public const CODE = 406;

    /**
     * ClassIsNotEventException constructor.
     *
     * @param string $className
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $className, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = str_replace(':class', $className, static::MESSAGE);
    }
}
