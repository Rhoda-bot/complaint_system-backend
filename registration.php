<?php
require_once("connect.php");
$fname = $formdata['fName'];
$lname =$formdata['lName'];
$email =$formdata['email'];
$phone =$formdata['phone'];
$pword =$formdata['password'];
$query =$database_obj->insertRegistrationInfos($fname,$lname,$email,$phone,$pword);
echo json_encode($query);
?>