<?php

namespace Solunsky\Interconnector\Request;

/**
 * Deleting a parcel
 * This method deletes a specific parcel. If shipment consists of more than one parcel, whole shipment
 * will be deleted in case if any parcel from this shipment is deleted.
 * Note: this function cannot be done in case if data has been transferred to DPD by closing manifest, by using
 * parcelDataSend_ or by automatic data transfer that is configured by DPD.
 *
 * Class DeleteShipment
 * @package Solunsky\Interconnector\Request
 */
class DeleteShipment extends Request
{
    private $numbers;

    public function __construct($authentication, $numbers)
    {
        parent::__construct($authentication);

        $this->numbers = $numbers;
    }

    public function get()
    {
        $body = array_merge(
            $this->authentication->credentials(),
            array(
                'parcels' => implode('|', $this->numbers),
            )
        );

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'parcelDelete_', $headers, $body);
    }
}
