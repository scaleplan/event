<?php

namespace Scaleplan\Event;

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

        self::$clearInstance->data = $data;
        self::$clearInstance->run();
    }

    /**
     * @var array
     */
    protected $data;

    /**
     * Event handler priority executor
     */
    public function run() : void
    {
    }
}