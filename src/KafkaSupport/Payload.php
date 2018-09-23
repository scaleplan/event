<?php

namespace Scaleplan\Event\KafkaSupport;

use RdKafka\Message;

/**
 * Class Payload
 *
 * @package Scaleplan\Event\KafkaSupport
 */
class Payload
{
    /**
     * @var \Scaleplan\Event\KafkaSupport\Node
     */
    protected $from;

    /**
     * Payload constructor.
     *
     * @param \RdKafka\Message $message
     */
    public function __construct(Message $message)
    {
    }
}