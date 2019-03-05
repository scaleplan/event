<?php

namespace Scaleplan\Event;

/**
 * Interface EventInterface
 *
 * @package Scaleplan\Event
 */
interface EventInterface
{
    public const NAME = '';

    /**
     * Trigger event
     *
     * @param array $data
     */
    public static function dispatch(array $data = []) : void;

    /**
     * Event handler priority executor
     */
    public function handler() : void;
}