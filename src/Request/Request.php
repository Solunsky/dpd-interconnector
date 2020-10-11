<?php

namespace Solunsky\Interconnector\Request;

use GuzzleHttp\Psr7\Request as GuzzleRequest;

/**
 * Class Request
 * @package Solunsky\Interconnector\Request
 */
class Request implements RequestInterface
{
    protected $authentication;

    public function __construct($authentication)
    {
        $this->authentication = $authentication;
    }

    /**
     * @inheritDoc
     */
    public function service()
    {
        return $this->authentication->service();
    }

    /**
     * @inheritDoc
     */
    public function build($method, $urn, $headers, $request)
    {
        return new GuzzleRequest(
            $method,
            $this->service() . $urn,
            $headers,
            http_build_query($request, null, '&')
        );
    }
}
