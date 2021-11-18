<?php
require_once("connect.php");
require_once("header.php");
$title = $formdata['title'];
$body = $formdata['complaint'];
$query = $database_obj->userLodgedComplaint($title,$body,$id);
echo json_encode($query);