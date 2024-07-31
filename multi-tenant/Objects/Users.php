<?php

class Users{

    private $userId;
    private $email;
    private $password;
    private $firstName;
    private $lastName;
    private $organisation;
    private $phoneNo;
    
    private $conn;
    private $tableName = 'users';

    public function __construct($email,$password,$firstName,$lastName,$organisation,$phoneNo){
        $this->email = $email;
        $this->password = $password;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->organisation = $organisation;
        $this->phoneNo = $phoneNo;
    }

    public function getDbOn($db){
        $this->conn = $db;
    }
    
    public  function autheticate($email,$Inputpassword,$organisation){

        $query = "SELECT * FROM users where email = ? AND organisation = ? ;";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param("ss",$email , $organisation);

        if(!$stmt->execute()){
            return [ "success"=>false , "message"=>"something wrong with db please try later"];
        }
        $result = $stmt->get_result();
        // num_rows
        if($result->num_rows <=0){
            return ["message"=>" username is not registred with  this organisation", "success"=>false];

        }

        $userData = $result->fetch_assoc();

        $storePassword = $userData["password"];

        if(! password_verify($Inputpassword,$storePassword)){
            return ["message"=>"can not login , password did not matched", "success"=>false];
        }
        return ["success"=>true , "message"=>"user has been authenticated","data"=>$userData];

    }

    
    public  function addUserEntry(){
        $query = " INSERT INTO ".$this->tableName." (email,password,firstName,lastName,phoneNo,organisation) VALUES (?,?,?,?,?,?) ;";
        $stmt  = $this->conn->prepare($query);

        $hashedPassword = password_hash($this->password, PASSWORD_BCRYPT);
        $stmt->bind_param("ssssss",$this->email, $hashedPassword ,$this->firstName,$this->lastName,$this->phoneNo,$this->organisation);
        
        if(!$stmt->execute()){
            return ["success"=>false , "message"=>"cant save the info some thing went wrong"];
        }
        return [
            "success"=>true,
            "message"=>"user has been created successfully"
        ];
    }
    

}
?>