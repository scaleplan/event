<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassNotImplementsEventInterfaceException;
use Scaleplan\Event\Interfaces\EventInterface;
use Scaleplan\Http\Hooks\SendError;

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
    protected static $asyncEvents = [];

    /**
     * @param string $className
     *
     * @throws ClassNotImplementsEventInterfaceException
     */
    protected static function eventClassCheck(string $className) : void
    {
        if (!class_exists($className) || !is_subclass_of($className, EventInterface::class)) {
            throw new ClassNotImplementsEventInterfaceException($className, EventInterface::class);
        }
    }

    /**
     * @param string $className
     * @param array $data
     *
     * @throws ClassNotImplementsEventInterfaceException
     */
    public static function dispatch(string $className, array $data = []) : void
    {
        /** @var EventInterface $className */
        static::eventClassCheck($className);
        $className::dispatch($data);
    }

    /**
     * @param string $className
     * @param array $data
     *
     * @throws ClassNotImplementsEventInterfaceException
     */
    public static function dispatchAsync(string $className, array $data = []) : void
    {
        static::eventClassCheck($className);
        static::$asyncEvents[] = static function () use ($className, $data) {
            try {
                /** @var EventInterface $className */
                $className::dispatch($data);
            } catch (\Throwable $e) {
                SendError::dispatch(['exception' => $e,]);
            }
        };
    }

    /**
     * @return array
     */
    public static function getAsyncEvents() : array
    {
        return self::$asyncEvents;
    }
}
