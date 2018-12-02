<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassIsNotEventException;

/**
 * Class EventDispatcher
 *
 * @package Scaleplan\Event
 */
class EventDispatcher
{
    /**
     * @var array
     */
    protected static $events = [];

    /**
     * @param array $events
     */
    public static function init(array $events)
    {
        static::$events = $events;
    }

    /**
     * @param string $eventName
     * @param array $data
     *
     * @return bool
     *
     * @throws ClassIsNotEventException
     */
    public static function dispatch(string $eventName, array $data = []) : bool
    {
        if (empty($eventClass = static::$events[$eventName])) {
            return false;
        }

        if (!($eventClass instanceof EventInterface)) {
            throw new ClassIsNotEventException();
        }

        $eventClass::dispatch($data);
        return true;
    }
}

/**
 * @param string $eventName
 * @param array $data
 *
 * @return bool
 *
 * @throws ClassIsNotEventException
 */
function dispatch(string $eventName, array $data = []) : bool
{
    return EventDispatcher::dispatch($eventName, $data);
}