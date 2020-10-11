<?php

namespace Solunsky\Interconnector;

/**
 * Class Authentication
 * @package Solunsky\Interconnector
 */
class Authentication implements AuthenticationInterface
{
    private $username;
    private $password;
    private $countryCode;
    private $url;
    private $debug;

    public function __construct($username, $password, $countryCode, $debug = false)
    {
        $this->username = $username;
        $this->password = $password;
        $this->countryCode = $countryCode;
        $this->debug = $debug;
    }

    /**
     * @inheritDoc
     */
    public function service()
    {
        if (!is_array($this->countryCode)) {

            $debug = $this->debug;
            $countryCode = strtoupper($this->countryCode);

            if ($countryCode == 'LT') {
                $url = $debug ? 'https://lt.integration.dpd.eo.pl/' : 'https://integracijos.dpd.lt/';
            }

            if ($countryCode == 'LV') {
                $url = $debug ? 'https://lv.integration.dpd.eo.pl/' : 'https://integration.dpd.lv:8443/';
            }

            if ($countryCode == 'EE') {
                $url = $debug ? 'https://ee.integration.dpd.eo.pl/' : 'https://integration.dpd.ee:8443/';
            }

            try {
                if ($url == '') {
                    throw new \Exception('Country code is not availble! Read the documentation: step 1');
                }
            } catch (\Exception $e) {
                echo $e->getMessage();
            }

            return $this->url = $url . 'ws-mapper-rest/';
        }

        foreach ($this->countryCode as $k => $v) {
            $this->countryCode = strtoupper($k);
            $this->url = $v;
        }

        return $this->url;
    }

    /**
     * @inheritDoc
     */
    public function credentials()
    {
        return array(
            'username' => $this->username,
            'password' => $this->password,
        );
    }
}
