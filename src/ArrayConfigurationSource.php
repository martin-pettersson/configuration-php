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
 * Array configuration source implementation.
 *
 * @see \N7e\Configuration\ConfigurationSourceInterface
 */
class ArrayConfigurationSource implements ConfigurationSourceInterface
{
    /**
     * Configuration source content.
     *
     * @var array
     */
    private array $content;

    /**
     * Create a new configuration source instance.
     *
     * @param array $content Configuration source content.
     */
    public function __construct(array $content)
    {
        $this->content = $content;
    }

    /** {@inheritDoc} */
    public function load(): array
    {
        return $this->content;
    }
}
