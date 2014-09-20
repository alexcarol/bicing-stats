<?php

namespace AlexCarol\Component\Framework;

class Query
{
    private $name;

    /**
     * @var array
     */
    private $arguments;

    public function __construct($name, array $arguments)
    {
        $this->name = $name;
        $this->arguments = $arguments;
    }

    /**
     * @return array
     */
    public function getArguments()
    {
        return $this->arguments;
    }

    /**
     * @return mixed
     */
    public function getName()
    {
        return $this->name;
    }
}
