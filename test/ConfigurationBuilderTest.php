<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace N7e\Configuration;

use PHPUnit\Framework\Attributes\Before;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(ConfigurationBuilder::class)]
class ConfigurationBuilderTest extends TestCase
{
    private ConfigurationBuilder $configurationBuilder;

    #[Before]
    public function setUp(): void
    {
        $this->configurationBuilder = new ConfigurationBuilder();
    }

    #[Test]
    public function shouldBuildEmptyConfigurationIfNoConfigurationSources(): void
    {
        $this->assertEmpty($this->configurationBuilder->build()->all());
    }

    #[Test]
    public function shouldUseGivenConfigurationSource(): void
    {
        $values = ['key' => 'value'];

        $this->assertEquals(
            $values,
            $this->configurationBuilder
                ->addConfigurationSource(new ArrayConfigurationSource($values))
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldMergeConfigurationSourceValues(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => 'value']);
        $source2 = new ArrayConfigurationSource(['anotherKey' => 'another value']);

        $this->assertEquals(
            [
                'key' => 'value',
                'anotherKey' => 'another value'
            ],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2)
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldMergeConfigurationSourceValuesRecursively(): void
    {
        $source1 = new ArrayConfigurationSource(['nested' => ['key' => 'value']]);
        $source2 = new ArrayConfigurationSource(['nested' => ['anotherKey' => 'another value']]);

        $this->assertEquals(
            [
                'nested' => [
                    'key' => 'value',
                    'anotherKey' => 'another value'
                ]
            ],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2)
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldReplaceIndexedArraysInConfigurationSourceValues(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => [1, 2, 3]]);
        $source2 = new ArrayConfigurationSource(['key' => [1, 2]]);

        $this->assertEquals(
            ['key' => [1, 2]],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2)
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldMergeIndexedArraysInConfigurationSourceValues(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => [1, 2, 3]]);
        $source2 = new ArrayConfigurationSource(['key' => [3, 4, 5]]);

        $this->assertEquals(
            ['key' => [1, 2, 3, 3, 4, 5]],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2)
                ->build(MergeStrategy::MERGE_ARRAYS)
                ->all()
        );
    }

    #[Test]
    public function shouldMergeIndexedArraysUniqueInConfigurationSourceValues(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => [1, 2, 3]]);
        $source2 = new ArrayConfigurationSource(['key' => [3, 4, 5]]);

        $this->assertEquals(
            ['key' => [1, 2, 3, 4, 5]],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2)
                ->build(MergeStrategy::MERGE_ARRAYS_UNIQUE)
                ->all()
        );
    }

    #[Test]
    public function shouldMergeConfigurationSourceValuesAtKey(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => 'value']);
        $source2 = new ArrayConfigurationSource(['anotherKey' => 'another value']);

        $this->assertEquals(
            [
                'key' => 'value',
                'nested' => [
                    'anotherKey' => 'another value'
                ]
            ],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2, 'nested')
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldMergeConfigurationSourceValuesAtNestedKey(): void
    {
        $source1 = new ArrayConfigurationSource(['key' => 'value']);
        $source2 = new ArrayConfigurationSource(['anotherKey' => 'another value']);

        $this->assertEquals(
            [
                'key' => 'value',
                'nested' => [
                    'section' => [
                        'anotherKey' => 'another value'
                    ]
                ]
            ],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2, 'nested.section')
                ->build()
                ->all()
        );
    }

    #[Test]
    public function shouldMergeConfigurationSourceValuesAtExistingKey(): void
    {
        $source1 = new ArrayConfigurationSource(['nested' => ['key' => 'value']]);
        $source2 = new ArrayConfigurationSource(['anotherKey' => 'another value']);

        $this->assertEquals(
            [
                'nested' => [
                    'key' => 'value',
                    'anotherKey' => 'another value'
                ]
            ],
            $this->configurationBuilder
                ->addConfigurationSource($source1)
                ->addConfigurationSource($source2, 'nested')
                ->build()
                ->all()
        );
    }
}
