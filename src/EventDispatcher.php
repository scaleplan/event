<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassIsNotEventException;
use Scaleplan\Event\Exceptions\EventNotFoundException;

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
     * @return string
     *
     * @throws ClassIsNotEventException
     * @throws EventNotFoundException
     */
    protected static function getEventClass(string $eventName, array $data = []) : string
    {
        if (empty($eventClass = static::$events[$eventName])) {
            throw new EventNotFoundException($eventName);
        }

        if (!class_exists($eventClass) || !is_subclass_of($eventClass, EventInterface::class)) {
            throw new ClassIsNotEventException();
        }

        return $eventClass;
    }

    /**
     * @param string $eventName
     * @param array $data
     *
     * @throws ClassIsNotEventException
     */
    public static function dispatch(string $eventName, array $data = []) : void
    {
        /** @var EventInterface $eventClass */
        $eventClass = static::eventNameCheck($eventName, $data);
        $eventClass::dispatch($data);
    }

    /**
     * @param string $eventName
     * @param array $data
     *
     * @throws ClassIsNotEventException
     */
    public static function dispatchAsync(string $eventName, array $data = []) : void
    {
        $eventClass = static::eventNameCheck($eventName, $data);
        register_shutdown_function(function () use ($eventClass, $data) {
            /** @var EventInterface $eventClass */
            $eventClass::dispatch($data);
        });
    }
}

/**
 * @param string $eventName
 * @param array $data
 *
 * @throws ClassIsNotEventException
 */
function dispatch(string $eventName, array $data = []) : void
{
    EventDispatcher::dispatch($eventName, $data);
}

/**
 * @param string $eventName
 * @param array $data
 *
 * @throws ClassIsNotEventException
 */
function dispatch_async(string $eventName, array $data = []) : void
{
    EventDispatcher::dispatchAsync($eventName, $data);
}
