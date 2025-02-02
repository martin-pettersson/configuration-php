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
 * Represents a fixed set of configuration object merge strategies.
 */
class MergeStrategy
{
    /**
     * Combine all array entries.
     */
    public const MERGE_ARRAYS = 1;

    /**
     * Combine array entries filtering out duplicates.
     */
    public const MERGE_ARRAYS_UNIQUE = 2;

    /**
     * Replace arrays at key paths using the last array.
     */
    public const REPLACE_ARRAYS = 3;
}
