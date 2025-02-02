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
 * Configuration builder implementation capable of configuring and producing configuration objects.
 */
class ConfigurationBuilder implements ConfigurationBuilderInterface
{
    use MergesConfigurationObjects;

    /**
     * Available configuration source definitions.
     *
     * @var array
     */
    private array $sources = [];

    /** {@inheritDoc} */
    public function build(int $mergeStrategy = MergeStrategy::REPLACE_ARRAYS): ConfigurationInterface
    {
        return new Configuration(
            array_reduce(
                $this->sources,
                function (array $mergedValues, $configurationSourceDefinition) use ($mergeStrategy): array {
                    [$configurationSource, $keyPath] = $configurationSourceDefinition;

                    return $this->merge($mergedValues, $configurationSource->load(), $keyPath, $mergeStrategy);
                },
                []
            )
        );
    }

    /** {@inheritDoc} */
    public function addConfigurationSource(
        ConfigurationSourceInterface $configurationSource,
        ?string $keyPath = null
    ): ConfigurationBuilderInterface {
        $this->sources[] = [$configurationSource, $keyPath];

        return $this;
    }

    /**
     * Produce a configuration object representing a merger between two given configuration objects.
     *
     * @param array $a Arbitrary configuration object.
     * @param array $b Arbitrary configuration object.
     * @param string|null $keyPath Key path to merge the second configuration object into.
     * @param int|null $strategy Merge strategy to use.
     * @return array Configuration object representing a merger between the two given configuration objects.
     */
    private function merge(array $a, array $b, ?string $keyPath, ?int $strategy): array
    {
        $configuration = new Configuration($a);
        $base = $keyPath ? (array) $configuration->get($keyPath, []) : $configuration->all();
        $values = $this->mergeConfigurationObjects($base, $b, $strategy ?? MergeStrategy::MERGE_ARRAYS_UNIQUE);

        if (! $keyPath) {
            return $values;
        }

        $configuration->set($keyPath, $values);

        return $configuration->all();
    }
}
