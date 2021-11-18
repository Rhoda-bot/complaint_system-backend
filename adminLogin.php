<?php
require_once("connect.php");
require_once("header.php");
$email = $formdata['email'];
$query = $database_obj->verifyAdmin($email);
echo json_encode($query);