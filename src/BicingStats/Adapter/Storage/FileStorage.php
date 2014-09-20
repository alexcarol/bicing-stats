<?php

namespace BicingStats\Adapter\Storage;

use AlexCarol\Component\Storage\Storage;

final class FileStorage implements Storage
{
    public function save(array $data)
    {
        file_put_contents($data['id'], json_encode($data));
    }

    public function flush()
    {
    }
}
