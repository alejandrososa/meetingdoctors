<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 00:01
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Filesystem\Writer;

class CsvWriter implements FileWriterInterface
{
    public function write(string $path, array $content): void
    {
        $fp = fopen($path, 'w');
        foreach ($content as $fields) {
            fputcsv($fp, $fields);
        }
        fclose($fp);
    }
}
