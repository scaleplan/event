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
    protected const CALLBACK_LABEL = 'callback';

    public const PRIORY_HIGH   = 0;
    public const PRIORY_MEDIUM = 1;
    public const PRIORY_LOW    = 2;

    /**
     * @var array
     */
    protected static $listeners = [];

    /**
     * @param string $eventName
     *
     * @return array
     */
    public static function getListeners(string $eventName) : array
    {
        return self::$listeners[$eventName] ?? [];
    }

    /**
     * @param string $className
     * @param string $priority
     * @param array $data
     *
     * @throws ClassNotImplementsListenerInterfaceException
     */
    public static function addListener(string $className, string $priority = self::PRIORY_LOW, array $data = []) : void
    {
        $eventName = static::class;
        if (array_key_exists($className, static::getListeners($eventName))) {
            return;
        }

        if (!class_exists($className) || !is_subclass_of($className, ListenerInterface::class)) {
            throw new ClassNotImplementsListenerInterfaceException($className);
        }

        static::$listeners[$eventName][$className] = [static::DATA_LABEL => $data, static::PRIORITY_LABEL => $priority];
    }

    /**
     * @param string $alias
     * @param callable $callback
     * @param string $priority
     */
    public static function addCallbackListener(
        string $alias,
        callable $callback,
        string $priority = self::PRIORY_LOW
    ) : void
    {
        $eventName = static::class;
        if (array_key_exists($alias, static::getListeners($eventName))) {
            return;
        }

        static::$listeners[$eventName][$alias] = [static::CALLBACK_LABEL => $callback, static::PRIORITY_LABEL => $priority];
    }

    /**
     * @param string $classNameOrAlias
     */
    public static function removeListener(string $classNameOrAlias) : void
    {
        $eventName = static::class;
        unset(static::$listeners[$eventName][$classNameOrAlias]);
    }

    /**
     * @param array $data
     */
    public static function dispatch(array $data = []) : void
    {
        $eventName = static::class;
        $listeners = static::getListeners($eventName);
        uasort($listeners, static function ($a, $b) {
            return ($a[static::PRIORITY_LABEL] <=> $b[static::PRIORITY_LABEL]);
        });
        foreach ($listeners as $name => $initData) {
            $callback = $initData[static::CALLBACK_LABEL] ?? null;
            if (isset($callback) && is_callable($callback)) {
                $callback();
            }

            /** @var ListenerInterface $listener */
            $listener = new $name();
            $listener->setData(array_merge($initData, $data));
            $listener->handler();
        }
    }
}
