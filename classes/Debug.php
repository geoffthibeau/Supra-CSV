<?php

class Debug {
    public static function show($data) {
        echo "<pre>";
        print_r($data);
        echo "</pre>";
    }

    public static function describe($data) {
        echo "<pre>";
        var_dump($data);
        echo "</pre>";
    }
}


