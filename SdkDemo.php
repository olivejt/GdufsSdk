<?php

include 'GdufsSdk.class.php';
session_start();
$request = new GdufsSdk();

$username = $_POST['username']; //学号
$password = $_POST['password']; //密码

$request->login($username, $password); //首次登录
$request->getUserInfo($username); //二次获取信息

?>