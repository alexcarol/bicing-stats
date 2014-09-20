<?php

namespace AlexCarol\Component\Framework;

interface CommandHandler
{
    public function handle(Command $command);
}
