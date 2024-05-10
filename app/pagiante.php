<?php

include_once 'db.php';

$db = new DB();
$db = $db->getConnection();

var_dump($db);