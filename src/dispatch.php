<?php

namespace Scaleplan\Event;

use Scaleplan\Event\Exceptions\ClassIsNotEventException;

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