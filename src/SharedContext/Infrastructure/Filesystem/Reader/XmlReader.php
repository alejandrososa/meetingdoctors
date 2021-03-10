<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 00:10
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Filesystem\Reader;

use SimpleXMLElement;

class XmlReader implements FileReaderInterface
{
    public function read(string $path): ?SimpleXMLElement
    {
        if(file_exists($path)){
            $data = file_get_contents($path);
            return new SimpleXMLElement($data);
        }

        return null;
    }
}
