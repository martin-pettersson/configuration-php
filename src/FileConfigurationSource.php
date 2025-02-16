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
 * Base class for file configuration sources of any type.
 */
abstract class FileConfigurationSource implements ConfigurationSourceInterface
{
    /**
     * Configuration file path.
     *
     * @var string
     */
    private string $file;

    /**
     * Create a new configuration source instance.
     *
     * @param string $file Configuration file path.
     */
    public function __construct(string $file)
    {
        $this->file = $file;
    }

    /**
     * Read the configuration file content.
     *
     * @return string Configuration file content.
     */
    protected function read(): string
    {
        $content = @file_get_contents($this->file);

        if ($content === false) {
            throw new ConfigurationFileNotFoundException($this->file);
        }

        return $content;
    }
}
