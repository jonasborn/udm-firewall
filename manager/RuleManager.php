<?php
require_once __DIR__ . "/../rule/Rule.php";

class RuleManager
{



    public static function write(NetworkManager $networkManager, $objects, $file) {
        $fp = fopen($file, 'w');
        foreach ($objects as $object) {
            $r = new Rule($object);
            print_r( json_decode(json_encode($r), true));
            fputcsv($fp, json_decode(json_encode($r), true));
        }


        fclose($fp);
    }


}