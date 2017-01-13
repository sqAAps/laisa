<?php
header("Access-Control-Allow-Origin: $http_origin");
require_once 'core.inc.php';
session_destroy();
header('Location: ../index.html');
?>