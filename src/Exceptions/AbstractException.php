<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use function Scaleplan\Translator\translate;

/**
 * Class AbstractException
 *
 * @package Scaleplan\Event\Exceptions
 */
abstract class AbstractException extends \Exception
{
    public const MESSAGE = 'event.event-error';
    public const CODE = 400;

    /**
     * AbstractException constructor.
     *
     * @param int $code
     * @param \Throwable|null $previous
     *
     * @throws \ReflectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ContainerTypeNotSupportingException
     * @throws \Scaleplan\DependencyInjection\Exceptions\DependencyInjectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ParameterMustBeInterfaceNameOrClassNameException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ReturnTypeMustImplementsInterfaceException
     */
    public function __construct(int $code = 0, \Throwable $previous = null)
    {
        parent::__construct(
            translate(static::MESSAGE),
            $code ?: static::CODE,
            $previous
        );
    }
}
