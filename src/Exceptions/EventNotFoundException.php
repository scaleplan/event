<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use function Scaleplan\Translator\translate;

/**
 * Class EventNotFoundException
 *
 * @package Scaleplan\Event\Exceptions
 */
class EventNotFoundException extends AbstractException
{
    public const MESSAGE = 'event.class-not-found';
    public const CODE = 404;

    /**
     * EventNotFoundException constructor.
     *
     * @param string $eventName
     * @param int $code
     * @param \Throwable|null $previous
     *
     * @throws \ReflectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ContainerTypeNotSupportingException
     * @throws \Scaleplan\DependencyInjection\Exceptions\DependencyInjectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ParameterMustBeInterfaceNameOrClassNameException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ReturnTypeMustImplementsInterfaceException
     */
    public function __construct(string $eventName, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = translate(static::MESSAGE, ['event' => $eventName,]) ?: static::MESSAGE;
    }
}
