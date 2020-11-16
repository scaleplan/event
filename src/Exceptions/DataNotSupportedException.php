<?php
declare(strict_types=1);

namespace Scaleplan\Event\Exceptions;

/**
 * Class DataNotSupportedException
 *
 * @package Scaleplan\Event\Exceptions
 */
class DataNotSupportedException extends AbstractException
{
    public const MESSAGE = 'event.db-notify-not-supported';
    public const CODE = 406;
}
