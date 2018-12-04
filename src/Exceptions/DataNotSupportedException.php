<?php

namespace Scaleplan\Event\Exceptions;

/**
 * Class DataNotSupportedException
 *
 * @package Scaleplan\Event\Exceptions
 */
class DataNotSupportedException extends AbstractException
{
    public const MESSAGE = 'Data sending not supported with notify to database';
}