<?php

require_once __DIR__ . "/manager/ArgManager.php";
require_once __DIR__ . "/manager/ConnectionManager.php";
require_once __DIR__ . "/manager/RuleManager.php";
require_once __DIR__ . "/manager/NetworkManager.php";
require_once __DIR__ . "/rule/FirewallRule.php";
require_once __DIR__ . "/rule/CSVRule.php";
require_once __DIR__ . "/util/Msg.php";

$argManager = new ArgManager();

$connectionManager = new ConnectionManager(
    $argManager->host,
    $argManager->port,
    $argManager->username,
    $argManager->password,
    $argManager->version,
    $argManager->totp
);

$connection = $connectionManager->connect();
$loginStatus = $connection->login();
if (!$loginStatus) {
    Msg::warn("Unable to login, check your credentials");
    exit(1);
}


$fp = fopen("test.csv", 'w');


fputcsv($fp, [
    "index", "active", "name", "ruleset", "protocol",
    "source-type", "source-address", "source-port" . "source-network", "source-address-group", "source-port-group",
    "target-type", "target-address", "target-port" . "target-network", "target-address-group", "target-port-group",
    "action"
]);

$sourceRules = [];
$remoteRules = $connection->list_firewallrules();
$remoteRulesSize = sizeof($remoteRules);
$index = 0;
foreach ($remoteRules as $rule) {
    //echo json_encode($rule);
    $r = new CSVRule($connection, $rule);
    //echo json_encode($rule, JSON_PRETTY_PRINT) . "\n" . "\n";
    //echo json_encode($r, JSON_PRETTY_PRINT) . "\n" . "\n";
    //echo json_encode(new FirewallRule($connection, $r), JSON_PRETTY_PRINT);
    array_push($sourceRules, new FirewallRule($connection, $r));

    fputcsv($fp, json_decode(json_encode($r), true));
    Msg::info("Parsed $index of $remoteRulesSize firewall rules");


    $index++;
}

$rules = [];
if (($handle = fopen("test.csv", "r")) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ",")) !== FALSE) {
        $r = new CSVRule($connection, array());
        $r->index = $data[0];
        $r->enabled = $data[1];
        $r->name = $data[2];
        $r->ruleset = $data[3];
        $r->protocol = $data[4];

        $r->source_type = $data[5];
        $r->source_address = $data[6];
        $r->source_port = $data[7];

        $r->source_network = $data[8];

        $r->source_address_group = $data[9];
        $r->source_port_group = $data[10];

        $r->target_type = $data[11];

        $r->target_address = $data[12];
        $r->target_port = $data[13];

        $r->target_network = $data[14];

        $r->target_address_group = $data[15];
        $r->target_port_group = @$data[16];

        $r->action = @$data[17];

        $fr = new FirewallRule($connection, $r);
        array_push($rules, $fr);
    }
    fclose($handle);
}
unset($rules[0]);
$rules = array_values($rules);

echo json_encode($sourceRules[0], JSON_PRETTY_PRINT);
echo "\n";
echo json_encode($rules[0], JSON_PRETTY_PRINT);