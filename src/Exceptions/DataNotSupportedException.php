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
    public const MESSAGE = 'Отправка уведомления с дополнительной информацией в базу данных не поддерживается.';
    public const CODE = 406;
}
