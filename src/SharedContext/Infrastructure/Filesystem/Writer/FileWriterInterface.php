<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 23:56
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Filesystem\Writer;

interface FileWriterInterface
{
    public function write(string $path, array $content): void;
}
