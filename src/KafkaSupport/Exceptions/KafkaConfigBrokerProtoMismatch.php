<?php

namespace Scaleplan\Event\KafkaSupport\Exceptions;

/**
 * Class KafkaConfigBrokerProtoMismatch
 *
 * @package Scaleplan\Event\Exceptions
 */
class KafkaConfigBrokerProtoMismatch extends AbstractException
{
    public const MESSAGE = 'Kafka config broker proto mismatch.';
}