<?php

namespace Scaleplan\Event\Exceptions;

/**
 * Class ListenerException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ListenerException extends AbstractException
{
    public const MESSAGE = 'Listener error.';
    public const CODE = 500;
}
