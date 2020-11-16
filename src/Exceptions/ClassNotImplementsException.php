<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use function Scaleplan\Translator\translate;

/**
 * Class ClassNotImplementsException
 *
 * @package Scaleplan\Event\Exceptions
 */
abstract class ClassNotImplementsException extends AbstractException
{
    public const MESSAGE = 'event.must-implements';
    public const CODE    = 406;

    /**
     * ClassNotImplementsException constructor.
     *
     * @param string $className
     * @param string $interfaceName
     * @param int $code
     * @param \Throwable|null $previous
     *
     * @throws \ReflectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ContainerTypeNotSupportingException
     * @throws \Scaleplan\DependencyInjection\Exceptions\DependencyInjectionException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ParameterMustBeInterfaceNameOrClassNameException
     * @throws \Scaleplan\DependencyInjection\Exceptions\ReturnTypeMustImplementsInterfaceException
     */
    public function __construct(string $className, string $interfaceName, int $code = 0, \Throwable $previous = null)
    {
        parent::__construct($code ?: static::CODE, $previous);
        $this->message = translate(static::MESSAGE, ['class' => $className, 'interface' => $interfaceName,])
            ?: static::MESSAGE;
    }
}
