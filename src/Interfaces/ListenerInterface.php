<?php
declare(strict_types=1);

namespace Scaleplan\Event\Interfaces;

/**
 * Class ListenerInterface
 *
 * @package Scaleplan\Event
 */
interface ListenerInterface
{
    /**
     * ListenerInterface constructor.
     *
     * @param array|mixed $data
     */
    public function __construct($data = []);

    /**
     * @return int
     */
    public function getPriority() : int;

    /**
     * @param int $priority
     */
    public function setPriority(int $priority) : void;

    /**
     * @param array $data
     */
    public function setData(array $data) : void;

    /**
     * Event handler priority executor
     */
    public function handler() : void;
}
