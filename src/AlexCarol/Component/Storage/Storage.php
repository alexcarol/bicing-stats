<?php

namespace AlexCarol\Component\Storage;

interface Storage
{
    public function save(array $data);

    public function flush();
}
