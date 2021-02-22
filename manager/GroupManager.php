<?php


use UniFi_API\Client;

class GroupManager
{

    private $idToName = [];
    private $nameToId = [];

    /**
     * GroupManager constructor.
     */
    public function __construct(Client $object)
    {
        foreach ($object->list_firewallgroups() as $group) {
            $this->idToName[$group->_id] = $group->name;
            $this->nameToId[$group->name] = $group->_id;
        }
    }

    public function resolveId($id) {
        if (empty($id)) return "" ;
        return @$this->idToName[$id];
    }

    public function resolveName($name) {
        if (empty($name)) return  "";
        return @$this->nameToId[$name];
    }



}