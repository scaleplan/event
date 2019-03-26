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
     * @param string $priority
     * @param array $data
     */
    public static function addListener(string $className, string $priority, array $data = []) : void;

    /**
     * @param string $className
     */
    public static function removeListener(string $className) : void;

    public static function dispatch(?object $object) : void;
}
