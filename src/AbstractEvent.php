<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\EventSendException;
use Scaleplan\Kafka\Kafka;
use Scaleplan\Kafka\Payload;

/**
 * Class AbstractEvent
 *
 * @package Scaleplan\Event
 */
abstract class AbstractEvent
{
    public const NAME = 'Abstract';

    public const KAFKA_TOPIC = null;

    /**
     * @var \Scaleplan\Event\AbstractEvent
     */
    public static $clearInstance;

    /**
     * Trigger event
     *
     * @param array $data
     */
    public static function dispatch(array $data = []) : void
    {
        if ($data) {
            $event = new static();
            $event->data = $data;
            $event->run();
            return;
        }

        if (!static::$clearInstance) {
            static::$clearInstance = new static();
        }

        static::$clearInstance->run();
    }

    /**
     * @param string $url
     * @param array $data
     *
     * @throws \Scaleplan\Event\Exceptions\EventSendException
     */
    public static function sendByHttp(string $url, array $data) : void
    {
        $content = ['event' => static::NAME, 'data' => $data];

        $options = [
            'http' => [
                'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
                'method'  => 'POST',
                'content' => json_encode($content, JSON_UNESCAPED_UNICODE),
            ]
        ];
        $context  = stream_context_create($options);
        $result = file_get_contents($url, false, $context);
        if ($result === false) {
            throw new EventSendException();
        }
    }

    public static function sendByKafka(array $data) : void
    {
        $kafka = Kafka::getInstance();
        $kafka->produce(static::KAFKA_TOPIC ?? static::NAME, $data);
    }

    /**
     * @var array
     */
    protected $data;

    /**
     * Event handler priority executor
     */
    protected function run() : void
    {
    }
}