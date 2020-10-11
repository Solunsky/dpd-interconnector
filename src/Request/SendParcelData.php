<?php

namespace Solunsky\Interconnector\Request;

/**
 *
 * This method submits shipment data to DPD. Regularity for this function can be adapted to client
 * processes, but it should be requested at least 30 minutes before courier arrival. If needed, can be used after
 * each parcel. It should not be used in case if manifest closure is used or if automatic data transfer is configured
 * by DPD.
 *
 * Class SendParcelData
 * @package Solunsky\Interconnector\Request
 */
class SendParcelData extends Request
{
    public function get()
    {
        $body = $this->authentication->credentials();

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'parcelDatasend_', $headers, $body);
    }
}
