<?php
require_once "fromrcon.php";
require_once "ayarlar.php";

$server = new Rcon();
$server->Connect($serverip, $serverport);

$servercon = $server->ServerInfo();

if($servercon)
    $server_online = true;
else
    $server_online = false;
?>
