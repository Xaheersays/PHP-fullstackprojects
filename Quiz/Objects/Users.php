<?php

class Users {

    // Database connection and table name
    private $conn;
    private $table_name = "users";


    public $UserId;
    public $UserName;
    public $Password;
    public $role;


    public function getDbOn($db){
        $this->conn = $db;
    }

    // Constructor to initialize database connection
    public function __construct($UserName, $Password, $role = 0) {
        $this->UserName = $UserName;
        $this->Password = $Password;
        $this->role = $role;
    }
    

   
    
    // Check if user exists by username
    public function isUserExists($UserName) {

        $query = "SELECT * FROM " . $this->table_name . " WHERE UserName = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s", $UserName);
        $stmt->execute();


        $result = $stmt->get_result();
        return $result->num_rows > 0;
    }



    public function createNewUser() {

        // Check if user already exists
        if ($this->isUserExists($this->UserName)) {
            return [
                "success" => false,
                "message" => "Username already exists"
            ];
        }
    
        $hashedPassword = password_hash($this->Password, PASSWORD_DEFAULT);
    
        $query = "INSERT INTO " . $this->table_name . " (UserName, Password, role) VALUES (?, ?, ?)";
        $stmt = $this->conn->prepare($query);
        
        if ($stmt === false) {
            return [
                "success" => false,
                "message" => "Failed to prepare statement"
            ];
        }
        $stmt->bind_param("ssi", $this->UserName, $hashedPassword, $this->role);

        if (!$stmt->execute()) {
            return [
                "success" => false,
                "message" => "Something went wrong: " . $stmt->error
            ];
        }
    
        return [
            "success" => true,
            "message" => "User has been created"
        ];
    }
    

    public function findUserByUserName($UserName){
        
      

        $query = "SELECT * FROM " . $this->table_name . " WHERE UserName = ?";

        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("s",$UserName);

        if(!$stmt->execute()){
            return ["success"=>false , "message"=>"something went wrong"];
        }
        $result = $stmt->get_result();
    
        if ($result->num_rows > 0) {
            return ["data"=>$result->fetch_assoc(),"success"=>true,"message"=>"user found in db" ] ;// Return the user data
        } else {
            return ["success"=>false , "message"=>"user not found with username as".$UserName];
        } 
    }

    public function login($UserName , $InputPassword){
        $userInfo = $this->findUserByUserName($UserName);
        if(!$userInfo){ 
            return  [
                "success" => false,
                "message" => "username not found"
            ];
        }
        //pass match
        if(password_verify($InputPassword , $userInfo["data"]["Password"])){
            return ["message"=>"login successful" ,"success"=>true ];
        }else{
            //pass unmatch
            return [
                'success' => false,
                'message' => 'Incorrect password.'
            ];
        }
        
    }
    

}
?>