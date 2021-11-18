<?php 
use Firebase\JWT\JWT;
class Database 
{
  private $servername = 'localhost';
  private $username = 'root';
  private $password = '';
  private $database = 'complaint_management_system';
  public function __Construct()
  {
    $conn = new mysqli($this->servername, $this->username, $this->password, $this->database);
    $this->conn = $conn;
    if (mysqli_error($conn)) {
      die();
    }
  }
  public function insertRegistrationInfos($fname,$lname,$email,$phone,$pword)
  {
   $insert_query = "INSERT INTO `registration_tb`( `firstname`, `lastname`, `email`, `phone`, `password`) VALUES (?,?,?,?,?)";
   $data = $this->conn->prepare($insert_query);
   $data->bind_param('sssss',$fname,$lname,$email,$phone,$pword);
   $data->execute();
   if (($data = $data->get_result())) {
     return $data;
    }else {
     return "Data added Successfully";
   }
  }
  public function verifyLogedUser($email)
  {
   $select_query = "SELECT `reg_id`, `email` FROM `registration_tb` WHERE email = ?";
   $data = $this->conn->prepare($select_query);
   $data->bind_param("s",$email);
   $data->execute();
  
   if (( $result = $data->get_result())) {
     $result= $result->fetch_assoc();
     $id = $result['reg_id'];
      $secret = "whatthehectdoyouneedasecretfor";
      $payload = array(["iss" => "localhost",
        "details" => [
          $email,
          $id
        ],
        "iat" => time(),
        "nbf" => time()*3600
    ]);
    $jwt = JWT:: encode($payload,$secret);
  //  print_r($jwt);
      return $jwt;
   }else {
     return "something went wrong";
   }   
  }
  public function userLodgedComplaint($title,$body,$user)
  {
    $insert_query = "INSERT INTO `complaint_tb`(`complain_title`, `complain_body`, `reg_id`) VALUES (?,?,?)";
    $data = $this->conn->prepare($insert_query);
    $data->bind_param("ssi",$title,$body,$user);
    $data->execute();
    if (($data = $data->get_result())) {
      return $data;
    }else {
      return "Data added Successfully";
    }
  }
  public function verifyAdmin($email)
  {
    $select_query = "SELECT  `email` FROM `admin` WHERE email = ?";
    $data=$this->conn->prepare($select_query);
    $data->bind_param('s',$email);
    $data->execute();
    if (($result = $data->get_result())) {
      return "admin is valid";
    }else {
      return "unvalid admin".$result;
    }
  }
  public function fetchAllComplains()
  {
    $fetch_query = "SELECT `complain_title`, `complain_body`, `reg_id` FROM `complaint_tb";
    $data =$this->conn->prepare($fetch_query);
    $data->execute();
    if (($data = $data->get_result())) {
      return $data->fetch_all(MYSQLI_ASSOC);
    }else {
      return "Encountered error";
    }
  }
}

?>