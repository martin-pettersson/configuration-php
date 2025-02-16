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
 * Has the ability to merge configuration objects.
 */
trait MergesConfigurationObjects
{
    use InspectsArrays;

    /**
     * Produce a configuration object representing a merger between two given configuration objects.
     *
     * @param array $a Arbitrary configuration object.
     * @param array $b Arbitrary configuration object.
     * @param int $strategy Merge strategy to use.
     * @return array Configuration object representing a merger between the two given configuration objects.
     */
    private function mergeConfigurationObjects(array $a, array $b, int $strategy): array
    {
        $values = $a;

        foreach ($b as $key => $value) {
            if (! array_key_exists($key, $values)) {
                $values[$key] = $value;

                continue;
            }

            if ($this->isAssociative($values[$key]) && $this->isAssociative($value)) {
                $values[$key] = $this->mergeConfigurationObjects($values[$key], $value, $strategy);

                continue;
            }

            if ($this->isList($values[$key]) && $this->isList($value)) {
                $values[$key] = $this->mergeLists($values[$key], $value, $strategy);

                continue;
            }

            $values[$key] = $value;
        }

        return $values;
    }

    /**
     * Produce an array representing a merger between two given arrays.
     *
     * @param array $a Arbitrary array.
     * @param array $b Arbitrary array.
     * @param int $strategy Merge strategy to use.
     * @return array Array representing a merger between the two given arrays.
     */
    private function mergeLists(array $a, array $b, int $strategy): array
    {
        if ($strategy === MergeStrategy::REPLACE_ARRAYS) {
            return $b;
        }

        $list = [...$a, ...$b];

        return $strategy === MergeStrategy::MERGE_ARRAYS_UNIQUE ? array_values(array_unique($list)) : $list;
    }
}
