<?php

namespace AlexCarol\Component\Framework;

final class Command
{
    private $name;
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
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}
