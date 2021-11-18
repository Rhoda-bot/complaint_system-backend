<?php
require_once("connect.php");
$email =$formdata['email'];
$query = $database_obj->verifyLogedUser($email);
echo json_encode($query);
?>