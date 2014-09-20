<?php

namespace AlexCarol\Component\Framework;

interface CommandHandler
{
    /**
     * @param Query $query
     *
     * @return mixed
     */
    public function handle(Query $query);
}
