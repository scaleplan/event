<?php

namespace Scaleplan\Event;

use Lmc\HttpConstants\Header;
use Scaleplan\Event\Exceptions\DataNotSupportedException;
use Scaleplan\Event\Interfaces\ListenerInterface;
use Scaleplan\Http\Request;
use Scaleplan\Kafka\Kafka;

/**
 * Class AbstractListener
 *
 * @package Scaleplan\Event
 */
abstract class AbstractListener implements ListenerInterface
{
    public const NAME = 'Abstract';

    public const KAFKA_TOPIC = null;

    /**
     * @var array
     */
    protected $data;

    /**
     * @var object|null
     */
    protected $object;

    /**
     * @param object|null $object
     */
    public function setObject(?object $object) : void
    {
        $this->object = $object;
    }

    /**
     * @param string $url
     * @param string|null $token
     *
     * @throws \Scaleplan\DTO\Exceptions\ValidationException
     * @throws \Scaleplan\Http\Exceptions\HttpException
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
