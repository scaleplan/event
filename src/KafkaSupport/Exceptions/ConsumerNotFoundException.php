<?php

namespace Scaleplan\Event\KafkaSupport\Exceptions;

/**
 * Class ConsumerNotFoundException
 *
 * @package Scaleplan\Event\Exceptions
 */
class ConsumerNotFoundException extends AbstractException
{
    public const MESSAGE = 'Consumer not found.';
}