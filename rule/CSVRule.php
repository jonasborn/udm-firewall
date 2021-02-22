<?php

use UniFi_API\Client;

require_once __DIR__ . "/../manager/GroupManager.php";
require_once __DIR__ . "/../manager/NetworkManager.php";

class CSVRule
{

    public $index;
    public $enabled;
    public $name;
    public $ruleset; //LAN_IN
    public $protocol; //TCP|UDP|...

    public $source_type; //NETv4|Gateway IP
    public $source_address;
    public $source_port;

    public $source_network; //guest

    public $source_address_group;
    public $source_port_group;

    public $target_type; //NETv4|Gateway IP

    public $target_address;
    public $target_port;

    public $target_network; //guest

    public $target_address_group;
    public $target_port_group;

    public $action;

    public static function getOrAlt($o, $alt)
    {
        if (empty($o)) return $alt;
        return $o;
    }

    /**
     * FirewallRule constructor.
     */
    public function __construct(Client $connection, $object)
    {
        $netman = new NetworkManager($connection);
        $grpman = new GroupManager($connection);

        if ($object == null) return;

        $this->index = $object->rule_index;
        $this->enabled = (empty($object->enabled) ? "false" : "true");
        $this->name = $object->name;
        $this->ruleset = $object->ruleset;
        $this->protocol = $object->protocol;

        $this->source_type = $object->src_networkconf_type;
        $this->source_address = $object->src_address;
        $this->source_port = $object->src_port;


        $this->source_network = $netman->resolveId($object->src_networkconf_id);

        $this->source_address_group = $grpman->resolveId(CSVRule::getOrAlt(@$object->src_firewallgroup_ids[0], ""));
        $this->source_port_group = CSVRule::getOrAlt(@$object->src_firewallgroup_ids[1], "");


        $this->target_type = $object->dst_networkconf_type;
        $this->target_address = $object->dst_address;
        $this->target_port = $object->dst_port;

        $this->target_network = $netman->resolveId($object->dst_networkconf_id);

        //echo "HERE\n";
        //echo $grpman->resolveId(CSVRule::getOrAlt(@$object->dst_firewallgroup_ids[0], "")) . "\n";
        //print_r($object->dst_firewallgroup_ids);


        $this->target_address_group = $grpman->resolveId(CSVRule::getOrAlt(@$object->dst_firewallgroup_ids[0], ""));
        $this->target_port_group = $grpman->resolveId(CSVRule::getOrAlt(@$object->dst_firewallgroup_ids[1], ""));

        $this->action = $object->action;
    }

    public function nullify($o) {
        if (empty($o)) return null;
        if (strlen($o) < 1) return null;
        return $o;
    }

}
