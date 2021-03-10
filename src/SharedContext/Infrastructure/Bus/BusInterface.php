<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 20:36
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Bus;

interface BusInterface
{
    const DELAY = 3000;

    public function dispatch($commandRequest): void;

    public function ask($queryRequest);

    public function notify($eventRequest, bool $delay = false): void;
}
