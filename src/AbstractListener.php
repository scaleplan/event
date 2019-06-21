<?php

namespace Scaleplan\Event;

use Lmc\HttpConstants\Header;
use Scaleplan\Event\Exceptions\DataNotSupportedException;
use Scaleplan\Event\Interfaces\ListenerInterface;
use Scaleplan\Http\Request;
use Scaleplan\InitTrait\InitTrait;
use Scaleplan\Kafka\Kafka;

/**
 * Class AbstractListener
 *
 * @package Scaleplan\Event
 */
abstract class AbstractListener implements ListenerInterface
{
    use InitTrait;

    public const EVENT_NAME = 'Abstract';

    public const KAFKA_TOPIC = null;

    /**
     * @var array
     */
    protected $data;

    /**
     * @param array $data
     */
    public function setData(array $data = []) : void
    {
        $this->data = $data;
        $this->initObject($data);
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
        $content = ['event' => static::EVENT_NAME, 'data' => $this->data];

        $request = new Request($url, $content);
        if ($token) {
            $request->addHeader(Header::AUTHORIZATION, $token);
        }

        $request->send();
    }

    protected function sendAsyncByKafka() : void
    {
        $kafka = Kafka::getInstance();
        $kafka->produce(static::KAFKA_TOPIC ?? static::EVENT_NAME, $this->data);
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

        $connection->exec('NOTIFY ' . static::EVENT_NAME);
    }

    /**
     * Event handler priority executor
     */
    abstract public function handler() : void;
}
