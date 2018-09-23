<?php

namespace Scaleplan\Event\KafkaSupport\Exceptions;

/**
 * Class KafkaConfigParseException
 *
 * @package Scaleplan\Event\Exceptions
 */
class KafkaConfigParseException extends AbstractException
{
    public const MESSAGE = 'Kafka config parse error.';
}