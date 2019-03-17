<?php

namespace Scaleplan\Event\Interfaces;

/**
 * Class ListenerInterface
 *
 * @package Scaleplan\Event
 */
interface ListenerInterface
{
    /**
     * Event handler priority executor
     */
    public function handler() : void;

    /**
     * @param object|null $object
     */
    public function setObject(?\object $object) : void;
}
