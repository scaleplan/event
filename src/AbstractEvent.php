<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassNotImplementsListenerInterfaceException;
use Scaleplan\Event\Interfaces\EventInterface;
use Scaleplan\Event\Interfaces\ListenerInterface;

/**
 * Class AbstractEvent
 *
 * @package Scaleplan\Event
 */
class AbstractEvent implements EventInterface
{
    protected const PRIORITY_LABEL = 'priority';
    protected const DATA_LABEL     = 'data';

    public const PRIORY_HIGH   = 0;
    public const PRIORY_MEDIUM = 1;
    public const PRIORY_LOW    = 2;

    /**
     * @var array
     */
    protected static $listeners = [];

    /**
     * @param string $className
     * @param string $priority
     * @param array $data
     *
     * @throws ClassNotImplementsListenerInterfaceException
     */
    public static function addListener(string $className, string $priority = self::PRIORY_LOW, array $data = []) : void
    {
        if (array_key_exists($className, static::$listeners)) {
            return;
        }

        if (!class_exists($className) || !is_subclass_of($className, ListenerInterface::class)) {
            throw new ClassNotImplementsListenerInterfaceException($className);
        }

        static::$listeners[$className] = [static::DATA_LABEL => $data, static::PRIORITY_LABEL => $priority];
    }

    /**
     * @param string $className
     */
    public static function removeListener(string $className) : void
    {
        unset(static::$listeners[$className]);
    }

    /**
     * @param array $data
     */
    public static function dispatch(array $data = []) : void
    {
        uasort(static::$listeners, static function ($a, $b) {
            return ($a[static::PRIORITY_LABEL] <=> $b[static::PRIORITY_LABEL]);
        });
        foreach (static::$listeners as $class => $initData) {
            /** @var ListenerInterface $listener */
            $listener = new $class();
            $listener->setData(array_merge($initData, $data));
            $listener->handler();
        }
    }
}
