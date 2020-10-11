<?php

namespace Solunsky\Interconnector\Request;

/**
 * Parcel label creation
 *
 * This method generates a parcel label. There’s a possibility to configure automatic data submission by
 * DPD triggered by parcel printing
 *
 * Class PrintLabel
 * @package Solunsky\Interconnector\Request
 */
class PrintLabel extends Request
{
    private $numbers;
    private $printType;
    private $printFormat;
    private $printSequence;
    private $printPosition;

    public function __construct(
        $authentication,
        $numbers,
        $printType = 'pdf',
        $printFormat = 'A6',
        $printSequence = 1,
        $printPosition = 'LeftTop'
    )
    {
        parent::__construct($authentication);

        $this->numbers = $numbers;
        $this->printType = $printType;
        $this->printFormat = $printFormat;
        $this->printSequence = $printSequence;
        $this->printPosition = $printPosition;
    }

    public function get()
    {
        $body = array_merge(
            $this->authentication->credentials(),
            array(
                'parcels' => implode('|', $this->numbers),
                'printType' => $this->printType,
                'printFormat' => $this->printFormat,
                'printSequence' => $this->printSequence,
                'printPosition' => $this->printPosition,
            )
        );

        $headers = array(
            'Content-Type' => 'application/x-www-form-urlencoded; charset=utf-8',
        );

        return $this->build('POST', 'parcelPrint_', $headers, $body);
    }
}
