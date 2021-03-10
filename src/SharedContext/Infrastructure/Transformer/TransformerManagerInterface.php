<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:07
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

interface TransformerManagerInterface
{
    public function setType($type): TransformerManagerInterface;
    public function setData($data): TransformerManagerInterface;
    public function transform(): array;
}
