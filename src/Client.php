<?php

namespace Solunsky\Interconnector;

use GuzzleHttp\Client as GuzzleClient;

/**
 * Class Client
 * @package Solunsky\Interconnector
 */
class Client implements ClientInterface
{
    private $params;

    public function __construct($params = array())
    {
        $this->params = $params;
    }

    /**
     * @inheritDoc
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    public function get($request, $jsonDecode = true)
    {
        $client = new GuzzleClient($this->params);

        $response = $client->send($request->get())->getBody()->getContents();

        if ($jsonDecode) {
            return json_decode($response, true);
        }

        return $response;
    }
}
