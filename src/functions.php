<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassNotImplementsEventInterfaceException;

/**
 * @param string $eventName
 * @param object|null $object
 *
 * @throws ClassNotImplementsEventInterfaceException
 */
function dispatch(string $eventName, object $object = null) : void
{
    EventDispatcher::dispatch($eventName, $object);
}

/**
 * @param string $eventName
 * @param object|null $object
 */
function dispatch_async(string $eventName, object $object = null) : void
{
    EventDispatcher::dispatchAsync($eventName, $object);
}
