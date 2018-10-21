<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassIsNotEventException;
use Symfony\Component\Yaml\Yaml;

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
     * @param string $configPath
     */
    public static function init(string $configPath)
    {
        static::$events = Yaml::parse(file_get_contents($configPath));
    }

    /**
     * @param string $eventName
     * @param array $data
     *
     * @return bool
     * @throws ClassIsNotEventException
     */
    public static function dispatch(string $eventName, array $data = [])
    {
        if (empty($eventClass = static::$events[$eventName])) {
            return false;
        }

        if (!($eventClass instanceof EventInterface)) {
            throw new ClassIsNotEventException();
        }

        $eventClass::dispatch($data);
    }
}

/**
 * @param string $eventName
 * @param array $data
 *
 * @throws ClassIsNotEventException
 */
function dispatch(string $eventName, array $data = [])
{
    EventDispatcher::dispatch($eventName, $data);
}