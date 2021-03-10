<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 13:13
 */

namespace MeetingDoctors\SalesContext\Customer\Application\Exception;

use Exception;

final class ErrorJsonResponse extends Exception
{
    public function __construct(string $error = '')
    {
        parent::__construct(sprintf("Error requesting api %s", $error));
    }
}
