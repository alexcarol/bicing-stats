<?php

namespace AlexCarol\Component\Framework;

interface QueryHandler
{
    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function handle(Query $query);
}
