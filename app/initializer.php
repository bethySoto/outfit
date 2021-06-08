<?php
//llamando a config
include_once "config/config.php";
//llamando a la url, encargado de redireccionarnos a la pantalla principal
include_once "helper/url_helper.php";

spl_autoload_register(function($file) {
    include_once "libs/" . $file . ".php";
});