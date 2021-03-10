<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:23
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

class TransformerFactory implements TransformerFactoryInterface
{
    /**
     * @var TransformerChain
     */
    private $transformers;

    public function __construct(TransformerChain $chain)
    {
        $this->transformers = $chain->getTransformers('transformer');
    }

    public function strategies(): ?array
    {
        $transformers = [];
        foreach ($this->transformers as $transformer) {
            $transformers[] = $transformer;
        }

        return $transformers;
    }
}
