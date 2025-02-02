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
 * Represents a configuration object capable of retrieving configuration values.
 */
interface ConfigurationInterface
{
    /**
     * Determine if a given key path has a value.
     *
     * @param string $keyPath Arbitrary key path.
     * @return bool True if the given key path has a value.
     */
    public function has(string $keyPath): bool;

    /**
     * Retrieve value for a given key path.
     *
     * @param string $keyPath Arbitrary key path.
     * @param mixed $defaultValue Default value to return if the given key path has no value.
     * @return mixed Value at key path or default value.
     */
    public function get(string $keyPath, $defaultValue = null);

    /**
     * Retrieve all available configuration values.
     *
     * @return array All available configuration values.
     */
    public function all(): array;

    /**
     * Set value for a given key path.
     *
     * @param string $keyPath Arbitrary key path.
     * @param mixed $value Arbitrary key path value.
     */
    public function set(string $keyPath, $value): void;

    /**
     * Remove a given key path and associated value.
     *
     * @param string $keyPath Arbitrary key path.
     */
    public function remove(string $keyPath): void;

    /**
     * Clear all key paths and associated values.
     */
    public function clear(): void;
}
