<?php
require '../config/Database.php';
// this file is only for db connection check 
$db = Database::getInstance();
var_dump($db);
