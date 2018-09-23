<?php

namespace Scaleplan\Event\KafkaSupport;

/**
 * Class Node
 *
 * @package Scaleplan\Event\KafkaSupport
 */
class Node
{
    protected $host;

    protected $id;

    /**
     * @return int
     */
    public function getId() : int
    {
        return $this->id;
    }
}