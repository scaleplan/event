<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use function Scaleplan\Translator\translate;

/**
 * Class ListenerException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ListenerException extends AbstractException
{
    public const MESSAGE = 'event.listener-error';
    public const CODE    = 500;

    /**
     * ListenerException constructor.
     *
     * @param string $message
     * @param int $code
     * @param \Throwable|null $previous
     *
     * @throws \ReflectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ContainerTypeNotSupportingException
     * @throws \Scaleplan\DependencyInjection\Exceptions\DependencyInjectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ParameterMustBeInterfaceNameOrClassNameException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ReturnTypeMustImplementsInterfaceException
     */
    public function __construct(string $message = '', int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code, $previous);
        $this->message = $message ?: translate(static::MESSAGE) ?: static::MESSAGE;
    }
}
