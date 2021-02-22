<?php


class Rule
{
//'{"action":"accept","dst_firewallgroup_ids":[],"enabled":true,"ipsec":"","logging":false,"name":"Test","protocol_match_excepted":false,
//"ruleset":"WAN_IN","src_firewallgroup_ids":[],"src_mac_address":"","state_established":false,
//"state_invalid":false,"state_new":false,"state_related":false,"dst_address":""
//,"dst_port":"","dst_networkconf_id":"","dst_networkconf_type":"NETv4",
//"icmp_typename":"","protocol":"all","src_address":"","src_port":"","src_networkconf_id":""
//,"src_networkconf_type":"NETv4","rule_index":"2000"}'

    public static function stringify($array) {
        if (is_array($array)) {
            return join("|", $array);
        } else {
            return $array;
        }
    }


    public $rule_index;
    public $ruleset;
    public $name;
    public $enabled;
    public $action;

    public $src_address;
    public $src_port;
    public $src_networkconf_id;
    public $src_networkconf_type;
    public $src_firewallgroup_ids;
    public $src_mac_address;

    public $dst_address;
    public $dst_port;
    public $dst_networkconf_id;
    public $dst_networkconf_type;
    public $dst_firewallgroup_ids;

    public $state_established;
    public $state_invalid;
    public $state_new;
    public $state_related;

    public $icmp_typename;
    public $protocol;
    public $protocol_match_excepted;

    public $logging;


    public function __construct($o)
    {
        $object = json_decode(json_encode($o), true);
        $this->rule_index = $object["rule_index"];
        $this->enabled = $object["enabled"];
        $this->name = $object["name"];
        $this->action = $object["action"];
        $this->protocol = $object["protocol"];

        $this->src_address = $object["src_address"];
        $this->src_port = $object["src_port"];
        $this->src_networkconf_id = $object["src_networkconf_id"];
        $this->src_networkconf_type = $object["src_networkconf_type"];
        $this->src_mac_address = $object["src_mac_address"];
        $this->src_firewallgroup_ids = Rule::stringify($object["src_firewallgroup_ids"]);

        $this->dst_address = $object["dst_address"];
        $this->dst_port = $object["dst_port"];
        $this->dst_networkconf_id = $object["dst_networkconf_id"];
        $this->dst_networkconf_type = $object["dst_networkconf_type"];
        $this->dst_firewallgroup_ids = Rule::stringify($object["dst_firewallgroup_ids"]);

        $this->state_established = $object["state_established"];
        $this->state_invalid = $object["state_invalid"];
        $this->state_new = $object["state_new"];
        $this->state_related = $object["state_related"];

        $this->icmp_typename = $object["icmp_typename"];
        $this->logging = $object["logging"];
        $this->ruleset = $object["ruleset"];
        $this->protocol_match_excepted = $object["protocol_match_excepted"];

    }


}