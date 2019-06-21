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
     * @param array $data
     */
    public function setData(array $data) : void;

    /**
     * Event handler priority executor
     */
    public function handler() : void;
}
