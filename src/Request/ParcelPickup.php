<?php

namespace Solunsky\Interconnector\Request;

/**
 * Parcel pickup request
 *
 * This method provides information for DPD that you need a courier that should pick up your parcels. It
 * has to be used in cases if there is no pre-agreed regular parcel’ pick-up time.
 *
 * Class ParcelPickup
 * @package Solunsky\Interconnector\Request
 */
class ParcelPickup extends Request
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

        return $this->build('POST', 'pickupOrderSave_', $headers, $body);
    }
}
