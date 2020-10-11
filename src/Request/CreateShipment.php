<?php

namespace Solunsky\Interconnector\Request;

/**
 * Shipment creation
 *
 * This method creates shipment that can contain one or multiple parcels.
 * The data that is needed for creating shipments will depend on DPD service that is requested.
 *
 * Class CreateShipment
 * @package Solunsky\Interconnector\Request
 */
class CreateShipment extends Request
{
    private $params;

    public function __construct($authentication, $params)
    {
        parent::__construct($authentication);

        $this->params = $params;
    }

    public function get()
    {
        $body = array_merge(
            $this->authentication->credentials(),
            $this->params
        );

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'createShipment_', $headers, $body);
    }
}
