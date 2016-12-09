<?php
header('Access-Control-Allow-Origin: *');
require_once 'core.inc.php';
session_destroy();
header('Location: ../index.html');
?>