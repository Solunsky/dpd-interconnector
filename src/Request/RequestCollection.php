<?php

namespace Solunsky\Interconnector\Request;

/**
 * Collection request
 * This method allows to order a courier to address of a third party. For example - for DPD client to
 * organize his customer a free return of goods (paid by DPD client not his customer).
 *
 * Class RequestCollection
 * @package Solunsky\Interconnector\Request
 */
class RequestCollection extends Request
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

        return $this->build('POST', 'crImport_', $headers, $body);
    }
}
