<?php

namespace Solunsky\Interconnector\Request;

/**
 * Interface RequestInterface
 * @package Solunsky\Interconnector\Request
 */
interface RequestInterface
{
    /**
     * Get API URL
     *
     * @return mixed
     */
    public function service();

    /**
     * Build request
     *
     * @param $method
     * @param $urn
     * @param $headers
     * @param $request
     * @return mixed
     */
    public function build($method, $urn, $headers, $request);
}
