<?php
function getDbConfig()
{
    $env = "LOCAL"; //PROD
    if ($env == "LOCAL") {
        return [
            "host" => "127.0.0.1",
            "dbname" => "bubblesdive",
            "port" => "3306",
            "username" => "root",
            "password" => "",
        ];
    } else {
        return [
            "host" => "bh-in-25",
            "dbname" => "vual_bubblesdive",
            "username" => "vual_vual",
            "password" => "gF.u&o*JzXg[",
        ];
    }
}
function getMailConfig()
{
    $domain = "connectia.in";
    return [
        "Host" =>  'mail.connectiainfotech.in;',
        "Username" => 'mailer@connectiainfotech.in',
        "Password" => 'P@ssw0rd123!',
        "From" => 'helpdesk@' . $domain,
        "FromName" => 'helpdesk',
        "PORT" => '587',
    ];
}
function getAppInfo()
{
    return [
        "BASE" => "",
    ];
}
