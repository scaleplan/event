<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

use Scaleplan\Event\Interfaces\EventInterface;

/**
 * Class ClassNotImplementsEventInterfaceException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassNotImplementsEventInterfaceException extends ClassNotImplementsException
{
    public const MESSAGE = 'Класс :class должен реализовывать ' . EventInterface::class;
    public const CODE    = 406;
}
