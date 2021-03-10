<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:29
 */

namespace MeetingDoctors\Tests\SalesContext\Customer\Infrastructure\Transformer;

use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\CustomerType;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\Exception\InvalidXmlData;
use MeetingDoctors\SalesContext\Customer\Infrastructure\Transformer\XmlCustomerTransformer;
use MeetingDoctors\Tests\SalesContext\Customer\CustomerUnitTestCase;

class XmlCustomerTransformerTest extends CustomerUnitTestCase
{
    /**
     * @var XmlCustomerTransformer
     */
    private $transformer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->transformer = new XmlCustomerTransformer();
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->transformer = null;
    }

    /**
     * @return string
     */
    protected function getXml(): string
    {
        return '<?xml version="1.0"?>
        <readings>
            <reading clientID="1" name="Taylor Glover" phone="463-170-9623 x156" company="Cargill">Taylor.Glover@gmail.com</reading>
        </readings>';
    }

    /**
     * @return string
     */
    protected function getBadXml(): string
    {
        return '<?xml version="1.0"?>
        <errors>500</errors>';
    }

    public function matchProvider(): array
    {
        return [
            'empty object'  => ['fake_type', false],
            'empty string' => [self::class, false],
            'array with correct values' => [CustomerType::XML, true],
        ];
    }

    public function test_throw_a_xml_exception()
    {
        $this->expectException(InvalidXmlData::class);
        $this->transformer->setData(new \SimpleXMLElement($this->getBadXml()));
        $this->transformer->transform();
    }

    /**
     * @dataProvider matchProvider
     * @param string $type
     * @param bool $expected
     */
    public function test_must_match_xml(string $type, bool $expected)
    {
        $this->assertEquals($expected, $this->transformer->isMatch($type));
    }

    public function test_transform_data_from_xml()
    {
        $expected = [[
            'name' => 'Taylor Glover',
            'email' => 'Taylor.Glover@gmail.com',
            'phone' => '463-170-9623 x156',
            'company' => 'Cargill'
        ]];

        $this->transformer->setData(new \SimpleXMLElement($this->getXml()));
        $this->assertEquals($expected, $this->transformer->transform());
    }
}
