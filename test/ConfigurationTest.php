<?php

/*
 * Copyright (c) 2023 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace N7e\Configuration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(Configuration::class)]
class ConfigurationTest extends TestCase
{
    private Configuration $configuration;

    #[Before]
    public function setUp(): void
    {
        $this->configuration = new Configuration([]);
    }

    #[Test]
    public function shouldDetermineIfKeyPathHasValue(): void
    {
        $this->assertFalse($this->configuration->has('key'));

        $this->configuration->set('key', 'value');

        $this->assertTrue($this->configuration->has('key'));
    }

    #[Test]
    public function shouldDetermineIfNestedKeyPathHasValue(): void
    {
        $this->assertFalse($this->configuration->has('nested.key'));

        $this->configuration->set('nested.key', 'value');

        $this->assertTrue($this->configuration->has('nested.key'));
    }

    #[Test]
    public function shouldNotThrowExceptionIfKeyPathIsOutOfBoundsWhenCheckingValue(): void
    {
        $this->configuration->set('key', 'value');

        $this->assertFalse($this->configuration->has('key.nested.key'));
    }

    #[Test]
    public function shouldRetrieveValueForKeyPath(): void
    {
        $this->configuration->set('key', 'value');

        $this->assertEquals('value', $this->configuration->get('key'));
    }

    #[Test]
    public function shouldRetrieveValueForNestedKeyPath(): void
    {
        $this->configuration->set('nested.key', 'value');

        $this->assertEquals('value', $this->configuration->get('nested.key'));
    }

    #[Test]
    public function shouldNotThrowExceptionIfNestedKeyPathIsOutOfBoundsWhenRetrievingValue(): void
    {
        $this->configuration->set('key', null);

        $this->assertNull($this->configuration->get('key.nested.key'));
    }

    #[Test]
    public function shouldReturnNullIfKeyPathHasNoValue(): void
    {
        $this->assertNull($this->configuration->get('key'));
    }

    #[Test]
    public function shouldReturnDefaultValueIfKeyPathHasNoValue(): void
    {
        $this->assertEquals('value', $this->configuration->get('key', 'value'));
    }

    #[Test]
    public function shouldBeEmptyByDefault(): void
    {
        $this->assertEmpty($this->configuration->all());
    }

    #[Test]
    public function shouldAcceptConstructorValues(): void
    {
        $values = ['key' => 'value'];

        $this->assertEquals($values, (new Configuration($values))->all());
    }

//    #[Test]
//    public function shouldReturnAllValues(): void
//    {
//        $values = ['key' => 'value'];
//        $nestedValues = [
//            'key' => 'value',
//            'nested' => [
//                'key' => 'value'
//            ]
//        ];
//
//        $this->configuration->set('key', 'value');
//
//        $this->assertEquals($values, $this->configuration->all());
//
//        $this->configuration->set('nested.key', 'value');
//
//        $this->assertEquals($values, $this->configuration->all());
//    }

    #[Test]
    public function shouldSetValueForKeyPath(): void
    {
        $this->configuration->set('key', 'value');

        $this->assertEquals('value', $this->configuration->get('key'));
    }

    #[Test]
    public function shouldSetValueForNestedKeyPath(): void
    {
        $this->configuration->set('nested.key', 'value');

        $this->assertEquals(['nested' => ['key' => 'value']], $this->configuration->all());
    }

    #[Test]
    public function shouldNotThrowExceptionIfNestedKeyPathIsOutOfBoundsWhenSettingValue(): void
    {
        $this->configuration->set('nested', null);
        $this->configuration->set('nested.key', 'value');

        $this->assertEquals(['nested' => ['key' => 'value']], $this->configuration->all());
    }

    #[Test]
    public function shouldRemoveValueFromKeyPath(): void
    {
        $configuration = new Configuration(['key' => 'value']);

        $configuration->remove('key');

        $this->assertFalse($configuration->has('key'));
    }

    #[Test]
    public function shouldRemoveValueFromNestedKeyPath(): void
    {
        $configuration = new Configuration(['nested' => ['key' => 'value']]);

        $configuration->remove('nested.key');

        $this->assertFalse($configuration->has('nested.key'));
    }

    #[Test]
    public function shouldNotThrowExceptionIfKeyPathIsOutOfBoundsWhenRemovingValue(): void
    {
        $this->configuration->remove('key');

        $this->assertFalse($this->configuration->has('key'));
    }

    #[Test]
    public function shouldNotThrowExceptionIfNestedKeyPathIsOutOfBoundsWhenRemovingValue(): void
    {
        $this->configuration->set('deeply', null);
        $this->configuration->remove('deeply.nested.key');

        $this->assertFalse($this->configuration->has('deeply.nested.key'));
    }

    #[Test]
    public function shouldClearAllConfigurationValues(): void
    {
        $configuration = new Configuration(['key' => 'value']);

        $configuration->clear();

        $this->assertEmpty($configuration->all());
    }
}
