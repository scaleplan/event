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
    public const MESSAGE = 'Notify to database with data sending not supported.';
    public const CODE = 406;
}
