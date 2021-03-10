<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 16:26
 */

namespace MeetingDoctors\SalesContext\Customer\Infrastructure\Http;

interface CustomerApiInterface
{
    public function fetchCustomers(): ?string;
}
