<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use Scaleplan\Event\Interfaces\ListenerInterface;

/**
 * Class ClassNotImplementsEventInterfaceException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassNotImplementsEventInterfaceException extends ClassNotImplementsException
{
    public const MESSAGE = 'Class :class must implements ' . ListenerInterface::class;
    public const CODE = 406;
}
