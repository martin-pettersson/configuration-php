<?php

/*
 * Copyright (c) 2025 Martin Pettersson
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

declare(strict_types=1);

namespace N7e\Configuration;

/**
 * Has the ability to inspect arrays.
 */
trait InspectsArrays
{
    /**
     * Determine whether the given value is an associative array.
     *
     * @param mixed $value Arbitrary value.
     * @return bool True if the given value is an associative array.
     */
    private function isAssociative($value): bool
    {
        return is_array($value) && (empty($value) || range(0, count($value) - 1) !== array_keys($value));
    }

    /**
     * Determine whether the given value is a non-associative array.
     *
     * @param mixed $value Arbitrary value.
     * @return bool True if the given value is a non-associative array.
     */
    private function isList($value): bool
    {
        return is_array($value) && (empty($value) || range(0, count($value) - 1) === array_keys($value));
    }
}
