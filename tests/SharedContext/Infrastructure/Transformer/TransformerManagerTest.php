<?php
/**
 * MeetingDoctors, Created by PhpStorm.
 * @author: Alejandro Sosa <alesjohnson@hotmail.com>
 * @copyright Copyright (c) 2021, 10/3/21 09:33
 */

namespace MeetingDoctors\Tests\SharedContext\Infrastructure\Transformer;

use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\DataIsEmptyException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\NoTransformerConfiguredException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\TransformerNotFoundException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\Exceptions\TypeIsEmptyException;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerInterface;
use MeetingDoctors\SharedContext\Infrastructure\Transformer\TransformerManager;
use MeetingDoctors\Tests\Common\Infrastructure\PHPUnit\IntegrationTestCase;

class TransformerManagerTest extends IntegrationTestCase implements TransformerInterface
{
    const NAME = 'test_transformer';

    private $data;

    private $manager;

    protected function setUp(): void
    {
        parent::setUp();

        $this->manager = new TransformerManager($this->transformerFactory());
    }

    protected function tearDown(): void
    {
        parent::tearDown();
        $this->manager = null;
        $this->data = null;
    }

    public function test_throw_an_exception_if_the_type_is_empty()
    {
        $this->expectException(TypeIsEmptyException::class);
        $this->manager->transform();
    }

    public function test_throw_an_exception_if_the_data_is_empty()
    {
        $this->expectException(DataIsEmptyException::class);
        $this->manager->setType('fake_type');
        $this->manager->transform();
    }

    public function test_throw_an_exception_if_no_transformer_configured()
    {
        $this->expectException(NoTransformerConfiguredException::class);
        $this->manager->setType('fake_type');
        $this->manager->setData('fake_data');
        $this->manager->transform();
    }

    public function test_it_should_return_an_empty_result_if_not_match_the_type()
    {
        $this->expectException(TransformerNotFoundException::class);

        $this->transformerFactoryShouldReturn([$this]);

        $this->manager->setType('fake_type');
        $this->manager->setData(['fake_type']);
        $this->manager->transform();
    }

    public function test_transform_the_content()
    {
        $this->expectException(TransformerNotFoundException::class);

        $this->transformerFactoryShouldReturn([$this]);

        $expected = ['fake_type'];

        $this->manager->setType('fake_type');
        $this->manager->setData(['fake_type']);

        $this->assertEquals($expected, $this->manager->transform());
    }


    //double fake transformer
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
        return $this->data;
    }
}
