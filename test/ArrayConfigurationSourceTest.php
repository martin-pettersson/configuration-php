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

#[CoversClass(ArrayConfigurationSource::class)]
class ArrayConfigurationSourceTest extends TestCase
{
    #[Test]
    public function shouldReturnValues(): void
    {
        $values = ['key' => 'values'];
        $configurationSource = new ArrayConfigurationSource($values);

        $this->assertEquals($values, $configurationSource->load());
    }
}
