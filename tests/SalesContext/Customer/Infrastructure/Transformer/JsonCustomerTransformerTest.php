<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:29
 */

namespace MeetingDoctors\Tests\SalesContext\Customer\Infrastructure\Transformer;

use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\CustomerType;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidJsonResponse;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\JsonCustomerTransformer;
use MeetingDoctors\Tests\SalesContext\Customer\CustomerUnitTestCase;

class JsonCustomerTransformerTest extends CustomerUnitTestCase
{
    /**
     * @var JsonCustomerTransformer
     */
    private $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new JsonCustomerTransformer();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->transformer = null;
    }

    /**
     * @return array
     */
    protected function getJson(): array
    {
        return [
            [
                'id' => 1,
                "name" => "Clementine Bauch",
                "email" => "Nathan@yesenia.net",
                "phone" => "1-463-123-4447",
                "website" => "ramiro.info",
                "company" => [
                    "name" => "Romaguera-Jacobson",
                ]
            ]
        ];
    }

    public function matchProvider(): array
    {
        return [
            'empty object'  => ['fake_type', false],
            'empty string' => [self::class, false],
            'array with correct values' => [CustomerType::JSON, true],
        ];
    }

    public function test_throw_a_json_exception()
    {
        $this->expectException(InvalidJsonResponse::class);
        $this->transformer->setData(json_encode([]));
        $this->transformer->transform();
    }

    /**
     * @dataProvider matchProvider
     * @param string $type
     * @param bool $expected
     */
    public function test_must_match_json(string $type, bool $expected)
    {
        $this->assertEquals($expected, $this->transformer->isMatch($type));
    }

    public function test_transform_data_from_json()
    {
        $expected = [[
            "name" => "Clementine Bauch",
            "email" => "Nathan@yesenia.net",
            "phone" => "1-463-123-4447",
            "company" => "Romaguera-Jacobson",
        ]];

        $this->transformer->setData(json_encode($this->getJson()));
        $this->assertEquals($expected, $this->transformer->transform());
    }
}
