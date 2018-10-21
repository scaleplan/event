<?php

namespace Scaleplan\Event\Exceptions;

use Scaleplan\Event\EventInterface;

/**
 * Class ClassIsNotEventException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ClassIsNotEventException extends AbstractException
{
    public const MESSAGE = 'Class ' . __CLASS__ . ' must implements ' . EventInterface::class;
}