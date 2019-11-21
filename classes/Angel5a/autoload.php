<?php

spl_autoload_register(function ($classname) {
    $classname = ltrim($classname, '\\');
    $namespace = 'Angel5a\\';
    $len = strlen($namespace);
    if (strncmp($namespace, $classname, $len) !== 0) {
        return;
    }
    $class = substr($classname, $len);
    $name = str_replace('\\', DIRECTORY_SEPARATOR, $class);
    $filename = dirname(__FILE__) . DIRECTORY_SEPARATOR . $name . '.php';
    if (file_exists($filename)) {
        require_once($filename);
    }
});
