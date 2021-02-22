<?php


class Msg
{

    private $package;

    /**
     * Msg constructor.
     * @param $package
     */
    public function __construct($package)
    {
        $this->package = $package;
    }


    public static function info(...$messages) {
        $trace = debug_backtrace();
        $class = @$trace[1]['class'];
        if (!isset($class)) $class = "Firewall";

        $message = "[INFO][$class] ";
        foreach ($messages as $part) {
            $message = $message . $part;
        }
        echo $message . "\n";
    }
    public static function warn(...$messages) {
        $trace = debug_backtrace();
        $class = @$trace[1]['class'];
        if (!isset($class)) $class = "Firewall";

        $message = "[WARN][$class] ";
        foreach ($messages as $part) {
            $message = $message . $part;
        }
        echo $message . "\n";
    }


}