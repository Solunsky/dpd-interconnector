<?php

namespace Solunsky\Interconnector\Request;

/**
 * Pickup point search
 *
 * This method provides a list of DPD Pickup points (parcel shops and pickup lockers).
 *
 * Class SearchPickupPoint
 * @package Solunsky\Interconnector\Request
 */
class SearchPickupPoint extends Request
{
    private $params;

    public function __construct(
        $authentication,
        $params
    )
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

        return $this->build('POST', 'parcelShopSearch_', $headers, $body);
    }
}
