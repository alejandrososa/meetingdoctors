<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 13:14
 */

namespace MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception;

use Exception;

final class InvalidJsonResponse extends Exception
{
    public function __construct()
    {
        parent::__construct(sprintf("Invalid json response"));
    }
}
