<?php

namespace Solunsky\Interconnector\Request;

/**
 * Manifest closure
 *
 * This method submits shipment data for shipments that are created on specific date and returns
 * document that contains information about all the parcels that has been created by the API user on this date and
 * that were not included in any other manifest. Regularity for this function can be adapted to client processes, but
 * it should be requested at least 30 minutes before courier arrival. If needed, can be used after each parcel. It
 * should not be used in case if parcel data submission method is used or if automatic data transfer is configured
 * by DPD.
 *
 * Class PrintManifest
 * @package Solunsky\Interconnector\Request
 */
class PrintManifest extends Request
{
    private $date;
    private $format;

    public function __construct($authentication, $date, $format = 'pdf')
    {
        parent::__construct($authentication);

        $this->date = $date;
        $this->format = $format;
    }

    public function get()
    {
        $body = array_merge(
            $this->authentication->credentials(),
            array(
                'date' => $this->date,
                'format' => $this->format,
            )
        );

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'parcelManifestPrint_', $headers, $body);
    }
}
