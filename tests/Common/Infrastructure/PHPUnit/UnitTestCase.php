<?php
/**
 * Ofertaski, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:51
 */

namespace MeetingDoctors\Tests\Common\Infrastructure\PHPUnit;

use Faker\Factory;
use Faker\Generator;
use PHPUnit\Framework\MockObject\MockObject;
use PHPUnit\Framework\TestCase;

abstract class UnitTestCase extends TestCase
{
    private $fake;

    protected function tearDown(): void
    {
        $this->fake = null;
    }

    /** @return Generator */
    protected function fake(): Generator
    {
        return $this->fake = $this->fake ?: Factory::create('es_ES');
    }

    protected function mock($className): MockObject
    {
        return $this->createMock($className);
    }
}
