<?php
declare(strict_types=1);

namespace Scaleplan\Event;

use Lmc\HttpConstants\Header;
use Scaleplan\Event\Exceptions\DataNotSupportedException;
use Scaleplan\Event\Interfaces\ListenerInterface;
use Scaleplan\Helpers\NameConverter;
use Scaleplan\Http\Request;
use Scaleplan\Kafka\Kafka;
use Scaleplan\Result\Interfaces\ArrayResultInterface;

/**
 * Class AbstractListener
 *
 * @package Scaleplan\Event
 */
abstract class AbstractListener implements ListenerInterface
{
    public const EVENT_NAME = 'Abstract';

    public const KAFKA_TOPIC = null;

    protected $priority = AbstractEvent::PRIORY_LOW;

    /**
     * @var mixed
     */
    protected $data;

    /**
     * AbstractListener constructor.
     *
     * @param array|mixed $data
     */
    public function __construct($data = [])
    {
        $this->setData($data);
    }

    /**
     * @return int
     */
    public function getPriority() : int
    {
        return $this->priority;
    }

    /**
     * @param int $priority
     */
    public function setPriority(int $priority) : void
    {
        $this->priority = $priority;
    }

    /**
     * Установка значений свойств в контексте объекта
     *
     * @param array $settings - массив свойства в формате 'имя' => 'значение'
     */
    protected function initObject(array $settings) : void
    {
        foreach ($settings as $name => &$value) {
            $propertyName = null;
            if (property_exists($this, $name)) {
                $propertyName = $name;
            }

            if ($propertyName === null
                && property_exists($this, NameConverter::snakeCaseToLowerCamelCase($name))) {
                $propertyName = NameConverter::snakeCaseToLowerCamelCase($name);
            }

            if (!$propertyName) {
                continue;
            }

            if (property_exists($this, $propertyName)) {
                $this->{$propertyName} = $value;
            }
        }

        unset($value);
    }

    /**
     * @param $data
     */
    public function setData($data) : void
    {
        if (is_array($data)) {
            $this->initObject($data);
            return;
        }

        $this->data = $data;
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
