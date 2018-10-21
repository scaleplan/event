<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\EventSendException;

/**
 * Class AbstractEvent
 *
 * @package Scaleplan\Event
 */
abstract class AbstractEvent
{
    public const NAME = 'Abstract';

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

        if (!self::$clearInstance) {
            self::$clearInstance = new static();
        }

        self::$clearInstance->run();
    }

    /**
     * @param string $url
     * @param array $data
     *
     * @throws \Scaleplan\Event\Exceptions\EventSendException
     */
    public static function sendByHttp(string $url, array $data = []) : void
    {
        $content = ['event' => static::NAME, 'data' => $data];

        // use key 'http' even if you send the request to https://...
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