<?php


class ArgManager
{
    public $operation;
    public $file;
    public $host;
    public $port;
    public $username;
    public $password;
    public $totp;
    public $version;

    public static function getRequired($index, $name, $content)
    {
        global $argv;
        $data = @$argv[$index];
        if (!isset($data)) {
            Msg::warn("Parameter $index '$name'($content) is missing");
            exit(1);
        } else {
            return $data;
        }

    }

    /**
     * ArgManager constructor.
     */
    public function __construct()
    {
        global $argv;

        Msg::info("Loading arguments");
        $this->operation = ArgManager::getRequired(1, "operation", "read/write");
        $this->file = ArgManager::getRequired(2, "file", "*.csv");

        $third = ArgManager::getRequired(3, "?", "<file>/host");
        if (file_exists($third)) {
            Msg::info("Loading arguments form file");
            //READ FROM JSON
            $array = json_decode(file_get_contents($third), true);
            $this->host = $array["host"];
            $this->port = $array["port"];
            $this->username = $array["username"];
            $this->password = $array["password"];
            $this->totp = $array["totp"];
            $this->version = $array["version"];
        } else {
            $this->host = $third;
            $this->port = ArgManager::getRequired(4, "port", "[0-9]+");;
            $this->username = ArgManager::getRequired(5, "username", "[0-9A-Za-z]+");;
            $this->password = ArgManager::getRequired(6, "password", ".+");;
            $this->version = ArgManager::getRequired(7, "version", ".+");
            if (isset($argv[8])) $this->totp = $argv[8];
        }
    }


}

