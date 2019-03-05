<?php

namespace Scaleplan\Event;

use Lmc\HttpConstants\Header;
use Scaleplan\Event\Exceptions\DataNotSupportedException;
use Scaleplan\Http\Request;
use Scaleplan\Kafka\Kafka;

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
     * @var array
     */
    protected $data;

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
            $event->handler();
            return;
        }

        if (!static::$clearInstance) {
            static::$clearInstance = new static();
        }

        static::$clearInstance->handler();
    }

    /**
     * @param string $url
     * @param string|null $token
     *
     * @throws \Scaleplan\Http\Exceptions\RemoteServiceNotAvailableException
     */
    protected function sendByHttp(string $url, string $token = null) : void
    {
        $content = ['event' => static::NAME, 'data' => $this->data];

        $request = new Request($url, $content);
        if ($token) {
            $request->addHeader(Header::AUTHORIZATION, $token);
        }

        $request->send();
    }

    protected function sendAsyncByKafka() : void
    {
        $kafka = Kafka::getInstance();
        $kafka->produce(static::KAFKA_TOPIC ?? static::NAME, $this->data);
    }

    /**
     * @param \PDO $connection
     *
     * @throws DataNotSupportedException
     */
    public function sendAsyncByDb(\PDO $connection) : void
    {
        if ($this->data) {
            throw new DataNotSupportedException();
        }

        $connection->exec('NOTIFY ' . static::NAME);
    }

    /**
     * Event handler priority executor
     */
    public function handler() : void
    {
    }
}