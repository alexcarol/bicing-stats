<?php

namespace AlexCarol\Component\Framework;

class QueryResult
{
    private $result;

    public function __construct($result)
    {
        $this->result = $result;
    }

    /**
     * @return mixed
     */
    public function getResult()
    {
        return $this->result;
    }
}
