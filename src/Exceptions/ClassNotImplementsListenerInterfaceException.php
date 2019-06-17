<?php

namespace Scaleplan\Event\Exceptions;

use Scaleplan\Event\Interfaces\ListenerInterface;

/**
 * Class ClassNotImplementsListenerInterfaceException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassNotImplementsListenerInterfaceException extends ClassNotImplementsException
{
    public const MESSAGE = 'Class :class must implements ' . ListenerInterface::class;
    public const CODE = 406;
}
