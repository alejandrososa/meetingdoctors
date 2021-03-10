<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:10
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

interface TransformerInterface
{
    public function name(): string;
    public function isMatch(string $type): bool;

    public function setData($content): TransformerInterface;
    public function transform(): array;
}
