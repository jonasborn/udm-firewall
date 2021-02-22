<?php


use UniFi_API\Client;

class NetworkManager
{

    private $connection;
    private $idToName = [];
    private $nameToId = [];

    /**
     * NetworkManager constructor.
     * @param Client $connection
     */
    public function __construct(Client $connection)
    {
        $this->connection = $connection;
        foreach ($connection->list_networkconf() as $network) {
            $this->idToName[$network->_id] = $network->name;
            $this->nameToId[$network->name] = $network->_id;
        }
    }

    public function resolveId(string $id) {
        return @$this->idToName[$id];
    }

    public function resolveName($name) {
        if (empty($name)) return "";
        return @$this->nameToId[$name];
    }

}