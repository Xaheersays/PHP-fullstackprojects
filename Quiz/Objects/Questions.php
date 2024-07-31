<?php


class Questions {

    // Database connection and table name
    private $conn;
    private $table_name = "question";


    public $questionId;
    public $questionTitle;
    public $questionDescription;


// Constructor to initialize database connection
    public function getDbOn($db){
        $this->conn = $db;
    }

    
    // public function __construct($questionId , $questionTitle, $questionDescription) {
    //     $this->questionId = $questionId;
    //     $this->questionTitle = $questionTitle;
    //     $this->questionDescription = $questionDescription;
    // }
    
    public function prepareQuestions($limit){

        $query = "SELECT * from question order by rand() limit  ?";
        
        $stmt  = $this->conn->prepare($query);

        $stmt->bind_param("i",$limit);

        if(!$stmt->execute()){
            return ["data"=>[], "success" => false , "message"=>"some thing went wrong with db"];
        }

        $result = $stmt->get_result();

        $questionList = $result->fetch_assoc();
        
        $questionList = [];
        while ($row = $result->fetch_assoc()) {
            $questionList[] = $row; //appending
        }


        return [ "data"=>$questionList , "success"=>false, "message"=>"got all the question"];



        //take 20 questions 

        // find their options in options table

        // return the array [ [qid=>'',qt='',qd=''] ]

    }
}
    



?>