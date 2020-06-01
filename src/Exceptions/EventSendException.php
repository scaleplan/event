<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

/**
 * Class EventSendException
 *
 * @package Scaleplan\Event\Exceptions
 */
class EventSendException extends AbstractException
{
    public const MESSAGE = 'Event send error.';
    public const CODE = 500;
}
