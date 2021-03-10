<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 18:07
 */

namespace MeetingDoctors\SharedContext\Infrastructure\Transformer;

use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\DataIsEmptyException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\NoTransformerConfiguredException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\TransformerNotFoundException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\TypeIsEmptyException;

class TransformerManager implements TransformerManagerInterface
{
    private $factory;
    private $type;
    private $data;

    public function __construct(TransformerFactoryInterface $factory)
    {
        $this->factory = $factory;
    }

    public function setType($type): TransformerManagerInterface
    {
        $this->type = $type;
        return $this;
    }

    public function setData($data): TransformerManagerInterface
    {
        $this->data = $data;
        return $this;
    }

    private function match(callable $function)
    {
        if (empty($this->type)) {
            throw new TypeIsEmptyException();
        }

        if (empty($this->data) && is_null($this->data)) {
            throw new DataIsEmptyException();
        }

        if (empty($this->factory->strategies())) {
            throw new NoTransformerConfiguredException();
        }

        foreach ($this->factory->strategies() as $transformer) {
            /** @var TransformerInterface $transformer */

            if ($transformer->isMatch($this->type)) {
                return $function($transformer, $this->data);
            }
        }

        throw new TransformerNotFoundException();
    }

    public function transform(): array
    {
        return $this->match(function (TransformerInterface $transformer, $content) {
            return $transformer->setData($content)->transform();
        });
    }
}
