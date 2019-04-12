<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassNotImplementsEventInterfaceException;
use Scaleplan\Event\Interfaces\EventInterface;

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
    public static function init(array $events) : void
    {
        static::$events = $events;
    }

    /**
     * @param string $className
     *
     * @throws ClassNotImplementsEventInterfaceException
     */
    protected static function eventClassCheck(string $className) : void
    {
        if (!class_exists($className) || !is_subclass_of($className, EventInterface::class)) {
            throw new ClassNotImplementsEventInterfaceException($className);
        }
    }

    /**
     * @param string $className
     * @param object|null $object
     *
     * @throws ClassNotImplementsEventInterfaceException
     */
    public static function dispatch(string $className, object $object = null) : void
    {
        /** @var EventInterface $className */
        static::eventClassCheck($className);
        $className::dispatch($object);
    }

    /**
     * @param string $className
     * @param object|null $object
     */
    public static function dispatchAsync(string $className, object $object = null) : void
    {
        register_shutdown_function(static function () use ($className, $object) {
            /** @var EventInterface $className */
            $className::dispatch($object);
        });
    }
}
