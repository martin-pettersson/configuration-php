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
 * Has the ability to build configured configuration objects.
 */
interface ConfigurationBuilderInterface
{
    /**
     * Build a configured configuration object.
     *
     * @param int $mergeStrategy Strategy to use when merging configuration values
     *     {@see \N7e\Configuration\MergeStrategy}.
     * @return \N7e\Configuration\ConfigurationInterface A configured configuration object.
     */
    public function build(int $mergeStrategy = MergeStrategy::REPLACE_ARRAYS): ConfigurationInterface;

    /**
     * Add given configuration source to be merged into configured configuration object.
     *
     * @param \N7e\Configuration\ConfigurationSourceInterface $configurationSource Arbitrary configuration source.
     * @param string|null $keyPath Key path for the given configuration source in the configured configuration object.
     * @return \N7e\Configuration\ConfigurationBuilderInterface Same instance for method chaining.
     */
    public function addConfigurationSource(
        ConfigurationSourceInterface $configurationSource,
        ?string $keyPath = null
    ): ConfigurationBuilderInterface;
}
