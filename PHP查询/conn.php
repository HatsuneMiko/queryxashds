<?php
header("Access-Control-Allow-Origin:*"); //跨域
require_once "fromrcon.php";

// 接收要查询的服务器地址
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
