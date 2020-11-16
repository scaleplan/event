<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassNotImplementsEventInterfaceException;

/**
 * @param string $eventName
 * @param array $data
 *
 * @throws ClassNotImplementsEventInterfaceException
 */
function dispatch(string $eventName, array $data = []) : void
{
    EventDispatcher::dispatch($eventName, $data);
}

/**
 * @param string $eventName
 * @param array $data
 *
 * @throws ClassNotImplementsEventInterfaceException
 */
function dispatch_async(string $eventName, array $data = []) : void
{
    EventDispatcher::dispatchAsync($eventName, $data);
}
