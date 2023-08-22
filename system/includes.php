<?php

include_once __DIR__ . "/nsp-class-autoloader/nspaloClassAutoloader.php";

/**
 * Autoload Classes
 */
nspaloClassAutoloader::load();

/**
 * function for debug
 */
function display($value)
{
  echo "<pre>";
  print_r($value);
  echo "</pre>";
}

function dump($value)
{
    echo "<pre>";
    var_dump($value);
    echo "</pre>";
}