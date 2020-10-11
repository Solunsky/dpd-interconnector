<?php

namespace Solunsky\Interconnector;

/**
 * Interface AuthenticationInterface
 * @package Solunsky\Interconnector
 */
interface AuthenticationInterface
{
    /**
     * Get API URL
     *
     * @return string
     */
    public function service();

    /**
     * Authentication
     *
     * @return array
     */
    public function credentials();
}
