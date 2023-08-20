<?php
header("Access-Control-Allow-Origin:*");
require_once "fromrcon.php";

// 设置要查询的服务器
$serverip   = $_GET["ds_ip"];
$serverport = $_GET["ds_port"];

$server = new Rcon();
$server->Connect($serverip, $serverport);


$servercon = $server->ServerInfo();

if($servercon)
    $server_online = true;
else
    $server_online = false;

?>
