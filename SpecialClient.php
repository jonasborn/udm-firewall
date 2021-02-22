<?php


class SpecialClient extends \UniFi_API\Client
{


    /**
     * SpecialClient constructor.
     */
    public function __construct($username, $password, $url, $site, $version, $verify)
    {
        parent::__construct($username, $password, $url, $site, $version, $verify);
    }


}