<?php

class Scores {

    // Database connection and table name
    private $conn;
    private $table_name = "scores";


    public $scoreId;
    public $UserId;
    public $attemptNo;
    public $score;


// Constructor to initialize database connection
    public function getDbOn($db){
        $this->conn = $db;
    }

    private function getAttemptNo($UserId){
        $query = "SELECT MAX(attemptNo) as attempt from scores WHERE userId = ?";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param("i",$UserId);
        
        if(!$stmt->execute()){
            
            return ["attemptNo"=>-1,"message"=>"somthing went wrong" , "success"=>false];
        }
        $results = $stmt->get_result();
        $count = $results->fetch_assoc()["attempt"];
        return [
            "attemptNo"=>$count , "message"=>"fetched attempts", "success"=>true
        ];

        


    }

    public function saveScore($userId , $score){
        $query = "INSERT INTO ".$this->table_name." (userId,attemptNo,score) VALUES ( ? , ? , ? )";
        $stmt  = $this->conn->prepare($query);
        $attemptData = $this->getAttemptNo($userId);
        if(!$attemptData["success"]){
            return ["message"=>$attemptData["message"] , "success"=>false];
        }

        $attemptNo = $attemptData["attemptNo"]+1;
        session_start();
        $_SESSION["attemptNo"] = $attemptNo;
        $stmt->bind_param("iii",$userId, $attemptNo,$score);

        if(!$stmt->execute()){
            return ["message"=>"somthing went wrong" , "success"=>false];
        }

        return ["message"=>"score saved to db" , "success"=>true];

    }

    public function getScore(){

    }

}


?>