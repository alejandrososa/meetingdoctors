<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 9/3/21 19:27
 */

namespace MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer;

use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidJsonResponse;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerInterface;

class JsonCustomerTransformer implements TransformerInterface
{
    const NAME = CustomerType::JSON;

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
        $this->data = json_decode($content, true);

        return $this;
    }

    public function transform(): array
    {
        $this->guardValidData($this->data);

        $customers = [];
        foreach ($this->data as $customer) {
            $customers[] = [
                'name' => $customer['name'] ?? null,
                'email' => $customer['email'] ?? null,
                'phone' => $customer['phone'] ?? null,
                'company' => $customer['company']['name'] ?? null,
            ];
        }

        return $customers;
    }

    /**
     * @param $customers
     * @throws InvalidJsonResponse
     */
    protected function guardValidData($customers): void
    {
        if(empty($customers)){
            throw new InvalidJsonResponse();
        }

        $first = current($customers);
        if (empty($first['id'])
            || empty($first['name'])
            || empty($first['email'])
            || empty($first['phone'])
            || empty($first['company'])) {
            throw new InvalidJsonResponse();
        }
    }
}
