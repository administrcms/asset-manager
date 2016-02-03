<?php

namespace Administr\Assets;


class Asset
{
    /**
     * @var string
     */
    private $name;
    /**
     * @var int
     */
    private $priority;

    public function __construct($name, $priority = 0)
    {
        $this->name = $name;
        $this->priority = $priority;
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return int
     */
    public function getPriority()
    {
        return $this->priority;
    }
}