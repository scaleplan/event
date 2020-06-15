<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

/**
 * Class ListenerException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ListenerException extends AbstractException
{
    public const MESSAGE = 'Ошибка слушателя события.';
    public const CODE    = 500;

    /**
     * EventNotFoundException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     */
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = $message ?: static::MESSAGE;
    }
}
