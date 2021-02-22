<?php


use UniFi_API\Client;

class FirewallRule
{


    //public $_id = "";                       // => 6019dd1631c5fa0629d2c461
    public $action = "accept";              // => accept
    public $dst_firewallgroup_ids = [];
    public $enabled = "";                   // => 1
    public $ipsec = "";                     // =>
    public $logging = "";                   // =>
    public $name = "";                      // => Test
    public $protocol_match_excepted = "";   // =>
    public $ruleset = "WAN_IN";             // => WAN_IN
    public $src_firewallgroup_ids = [];
    public $src_mac_address = "";           // =>
    public $state_established = "";         // =>
    public $state_invalid = "";             // =>
    public $state_new = "";                 // =>
    public $state_related = "";             // =>
    public $dst_address = "";               // =>
    public $dst_port = "";                  // =>
    public $dst_networkconf_id = "";        // =>
    public $dst_networkconf_type = "NETv4"; // => NETv4
    public $icmp_typename = "";             // =>
    public $protocol = "all";               // => all
    public $src_address = "";               // =>
    public $src_port = "";                  // =>
    public $src_networkconf_id = "";        // =>
    public $src_networkconf_type = "NETv4"; // => NETv4
    public $rule_index = "2000";            // => 2000
    public $site_id = "";                   // => 5e541e8ab6ef9c0522cf5d74

    /**
     * Rule2 constructor.
     * @param CSVRule $rule
     */
    public function __construct(Client $client, CSVRule $rule)
    {
        $netman = new NetworkManager($client);
        $grpman = new GroupManager($client);

        $this->action = $rule->action;
        $this->dst_firewallgroup_ids = [
            $grpman->resolveName($rule->target_address_group),
            $grpman->resolveName($rule->target_port_group),
        ];
        $this->enabled = $rule->enabled == "true";
        $this->name = $this->createName($rule);
        //$ipsec
        //$logging
        //$protocol_match_excepted
        $this->ruleset = $rule->ruleset;
        $this->src_firewallgroup_ids = [
            $grpman->resolveName($rule->source_address_group),
            $grpman->resolveName($rule->source_port_group),
        ];
        //$src_mac_address
        //$state_established
        //$state_invalid
        //$state_new
        //$state_related
        $this->dst_address = $rule->target_address;
        $this->dst_port = $rule->target_port;
        $this->dst_networkconf_id = $netman->resolveName($rule->target_network);
        $this->dst_networkconf_type = $rule->target_type;
        //$icmp_typename
        $this->protocol = $rule->protocol;
        $this->src_address = $rule->source_address;
        $this->src_port = $rule->source_port;
        $this->src_networkconf_id = $netman->resolveName($rule->source_network);
        $this->src_networkconf_type = $rule->source_type;
        $this->rule_index = intval($rule->index);
        //$site_id

    }

    public function createName(CSVRule $rule)
    {
        $source = "";
        if ($this->isFilled($rule->source_address)) $source = $rule->source_address;
        if ($this->isFilled($rule->source_network)) $source = $rule->source_network;
        if ($this->isFilled($rule->source_address_group)) $source = $rule->source_address_group;

        $target = "";
        if ($this->isFilled($rule->target_address)) $target = $rule->target_address;
        if ($this->isFilled($rule->target_network)) $target = $rule->target_network;
        if ($this->isFilled($rule->target_address_group)) $target = $rule->target_address_group;


        return $rule->action . " " . $rule->ruleset . " @ " . $source . "(" . $rule->source_type . ") > " . $target . "(" . $rule->target_type . ")";
    }

    public function isFilled($o)
    {
        if (empty($o)) return false;
        if (strlen($o) < 1) return false;
        return true;
    }


}