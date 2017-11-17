<?php

namespace DigipolisGent\Github\Core\Filter;

/**
 * Filter by one or more regular expression patterns.
 *
 * @package DigipolisGent\Github\Core\Filter
 */
class Pattern implements FilterInterface
{
    /**
     * Patterns to filter by.
     *
     * @var array
     */
    private $patterns = array();

    /**
     * Pass the patterns to filter by during creation.
     *
     * @param array $patterns
     */
    public function __construct($patterns)
    {
        $this->patterns = $patterns;
    }

    /**
     * Check if a string passes the filters.
     *
     * @param string $value
     *
     * @return bool
     */
    public function passes($value)
    {
        $count = 0;
        preg_replace($this->patterns, '', $value, -1, $count);
        return (bool) $count;
    }
}