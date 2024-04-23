<?php

function redirect($url)
{
    require_once __DIR__ . '/../config/config.php';
    $config = getAppInfo();
    $base = $config["BASE"];
    return header("location:" . $base . "$url");
}
