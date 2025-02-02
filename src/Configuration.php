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
 * An in-memory configuration object implementation.
 */
class Configuration implements ConfigurationInterface
{
    use InspectsArrays;

    /**
     * Available configuration values.
     *
     * @var array
     */
    private array $values;

    /**
     * Create a new configuration object.
     *
     * @param array $values Available configuration values.
     */
    public function __construct(array $values)
    {
        $this->values = $values;
    }

    /** {@inheritDoc} */
    public function has(string $keyPath): bool
    {
        $values = $this->values;

        foreach (explode('.', $keyPath) as $key) {
            if (! is_array($values) || ! array_key_exists($key, $values)) {
                return false;
            }

            $values = $values[$key];
        }

        return true;
    }

    /** {@inheritDoc} */
    public function get(string $keyPath, $defaultValue = null)
    {
        $values = $this->values;

        foreach (explode('.', $keyPath) as $key) {
            if (! is_array($values) || ! array_key_exists($key, $values)) {
                return $defaultValue;
            }

            $values = $values[$key];
        }

        return $values;
    }

    /** {@inheritDoc} */
    public function all(): array
    {
        return $this->values;
    }

    /** {@inheritDoc} */
    public function set(string $keyPath, $value): void
    {
        $values = &$this->values;

        foreach (explode('.', $keyPath) as $key) {
            if (! $this->isAssociative($values)) {
                $values = [];
            }

            $values = &$values[$key];
        }

        $values = $value;
    }

    /** {@inheritDoc} */
    public function remove(string $keyPath): void
    {
        $values = &$this->values;
        $keys = explode('.', $keyPath);

        foreach (array_slice($keys, 0, count($keys) - 1) as $key) {
            if (! $this->isAssociative($values)) {
                return;
            }

            $values = &$values[$key];
        }

        unset($values[end($keys)]);
    }

    /** {@inheritDoc} */
    public function clear(): void
    {
        $this->values = [];
    }
}
