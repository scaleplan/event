<?php

namespace Scaleplan\Event;

use Lmc\HttpConstants\Header;
use Scaleplan\Event\Exceptions\DataNotSupportedException;
use Scaleplan\Event\Interfaces\ListenerInterface;
use Scaleplan\Http\Request;
use Scaleplan\InitTrait\InitTrait;
use Scaleplan\Kafka\Kafka;
use Scaleplan\Result\Interfaces\ArrayResultInterface;

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

    protected $priority = AbstractEvent::PRIORY_LOW;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * @param array $data
     */
    public function setData(array $data = []) : void
    {
        $otherData = $this->initObject($data);
        if ($otherData) {
            $this->data = $otherData;
        }
    }

    /**
     * @return array
     */
    protected function getDataAsStringArray() : array
    {
        $data = [];
        if ($this->data instanceof ArrayResultInterface) {
            $data = $this->data->getResult();
        }

        if (is_array($this->data)) {
            $data = $this->data;
        }

        return \array_map(static function ($item) {
            if (\is_object($item)) {
                $item = (string)$item;
            }

            return $item;
        }, $data);
    }

    /**
     * @return string
     */
    protected function getDataAsString() : string
    {
        $data = \array_map(static function ($item) {
            $json = json_decode($item, true);
            return $json !== null || strtolower($item) === 'null' ? $json : $item;
        }, $this->getDataAsStringArray());

        return json_encode($data, JSON_OBJECT_AS_ARRAY | JSON_NUMERIC_CHECK | JSON_UNESCAPED_SLASHES
            | JSON_UNESCAPED_UNICODE | JSON_PRESERVE_ZERO_FRACTION);
    }

    //protected function getDataAsStringArray

    /**
     * @param string $url
     * @param string|null $token
     *
     * @throws \Throwable
     */
    protected function sendByHttp(string $url, string $token = null) : void
    {
        $content = ['event' => static::EVENT_NAME, 'data' => $this->getDataAsStringArray()];

        $request = new Request($url, $content);
        if ($token) {
            $request->addHeader(Header::AUTHORIZATION, $token);
        }

        $request->send();
    }

    protected function sendAsyncByKafka() : void
    {
        $kafka = Kafka::getInstance();
        $kafka->produce(static::KAFKA_TOPIC ?? static::EVENT_NAME, $this->getDataAsString());
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

        $connection->exec('NOTIFY ' . static::EVENT_NAME . ", '{$this->getDataAsString()}'");
    }

    /**
     * Event handler priority executor
     */
    abstract public function handler() : void;
}
