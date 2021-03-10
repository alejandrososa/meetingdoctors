<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:10
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

interface TransformerFactoryInterface
{
    public function strategies(): ?array;
}
