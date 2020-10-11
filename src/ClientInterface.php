<?php

namespace Solunsky\Interconnector;

/**
 * Interface ClientInterface
 * @package Solunsky\Interconnector
 */
interface ClientInterface
{
    /**
     * Get response from request
     *
     * @param $request
     * @param $jsonDecode
     * @return mixed
     */
    public function get($request, $jsonDecode);
}
