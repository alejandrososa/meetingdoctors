<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:08
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

class TransformerChain
{
    protected $transformer = [];

    public function addTransformer(TransformerInterface $transformer, string $alias)
    {
        $this->transformer[][$alias] = $transformer;
    }

    public function getTransformers(string $alias): array
    {
        $transformers = [];
        foreach ($this->transformer as $transformer) {
            if (array_key_exists($alias, $transformer)) {
                foreach ($transformer as $strategy) {
                    $transformers[] = $strategy;
                }
            }
        }

        return $transformers;
    }
}