<?php

use OTPHP\TOTP;

require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . "/../util/Msg.php";

class ConnectionManager
{
    private $host;
    private $port;

    private $username;
    private $password;
    private $totp;
    private $version;

    /**
     * Connection constructor.
     * @param $host
     * @param $port
     * @param $username
     * @param $password
     * @param $totp
     * @param $version
     */
    public function __construct($host, $port, $username, $password,  $version, $totp = null)
    {
        $this->host = $host;
        $this->port = $port;
        $this->username = $username;
        $this->password = $password;
        $this->version = $version;
        $this->totp = $totp;
    }


    private function createURL()
    {
        return "https://" . $this->host . ":" . $this->port;
    }

    private function createPassword()
    {
        if (!empty($this->totp)) {
            $otp = TOTP::create($this->totp);
            return $this->password . "|" . $otp->now();
        } else {
            return $this->password;
        }
    }

    public function connect()
    {
        Msg::info("Connecting to $this->host:$this->port");
        $unifi_connection = new UniFi_API\Client(
            $this->username,
            $this->createPassword(),
            $this->createURL(),
            "default",
            $this->version,
            false
        );
        return $unifi_connection;



    }

}