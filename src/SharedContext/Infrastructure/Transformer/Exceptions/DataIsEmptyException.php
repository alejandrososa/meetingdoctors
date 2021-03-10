<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:57
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions;

class DataIsEmptyException extends \Exception
{
    public function __construct()
    {
        parent::__construct('Transformer data is empty');
    }
}
