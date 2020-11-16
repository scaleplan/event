<?php

namespace Scaleplan\Event\Interfaces;

/**
 * Class EventInterface
 *
 * @package Scaleplan\Event
 */
interface EventInterface
{
    /**
     * @param string $className
     * @param int $priority
     * @param array $data
     */
    public static function addListener(string $className, int $priority, array $data = []) : void;

    /**
     * @param string $className
     */
    public static function removeListener(string $className) : void;

    /**
     * @param array $data
     */
    public static function dispatch(array $data = []) : void;
}
