<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

/**
 * Class EventNotFoundException
 *
 * @package Scaleplan\Event\Exceptions
 */
class EventNotFoundException extends AbstractException
{
    public const MESSAGE = 'Класс :event не найден.';
    public const CODE = 404;

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
