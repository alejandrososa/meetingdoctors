<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 19:27
 */

namespace MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer;

use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidXmlData;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerInterface;
use SimpleXMLElement;

class XmlCustomerTransformer implements TransformerInterface
{
    const NAME = CustomerType::XML;

    private $data;

    public function name(): string
    {
        return self::NAME;
    }

    public function isMatch(string $type): bool
    {
        return self::NAME === $type;
    }

    public function setData($content): TransformerInterface
    {
        $this->data = $content;

        return $this;
    }

    public function transform(): array
    {
        $this->guardIsValidXmlElement();
        $this->guardIsValidaXmlData();

        $customers = [];
        foreach ($this->data as $item) {
            $customers[] = [
                'name' => (string)$item->attributes()->name,
                'email' => (string)$item,
                'phone' => (string)$item->attributes()->phone,
                'company' => (string)$item->attributes()->company,
            ];
        }

        return $customers;
    }

    private function guardIsValidXmlElement(): void
    {
        if (!$this->data instanceof SimpleXMLElement) {
            throw new InvalidXmlData();
        }
    }

    private function guardIsValidaXmlData(): void
    {
        if ($this->data->getName() !== 'readings') {
            throw new InvalidXmlData();
        }
    }
}
