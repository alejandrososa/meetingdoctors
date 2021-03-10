<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 23:56
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Filesystem\Reader;

interface FileReaderInterface
{
    public function read(string $path);
}
