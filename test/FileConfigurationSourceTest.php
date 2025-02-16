<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e\Configuration;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

#[CoversClass(FileConfigurationSource::class)]
class FileConfigurationSourceTest extends TestCase
{
    #[Test]
    public function shouldReadFile(): void
    {
        $configurationSource = new class(__DIR__ . '/fixtures/content.txt') extends FileConfigurationSource {
            public function load(): array
            {
                return ['content' => $this->read()];
            }
        };

        $this->assertEquals(['content' => "content\n"], $configurationSource->load());
    }

    #[Test]
    public function shouldThrowIfFileNotFound(): void
    {
        $this->expectException(ConfigurationFileNotFoundException::class);

        $configurationSource = new class(__DIR__ . '/fixtures/non-existent.txt') extends FileConfigurationSource {
            public function load(): array
            {
                return ['content' => $this->read()];
            }
        };

        $configurationSource->load();
    }
}
