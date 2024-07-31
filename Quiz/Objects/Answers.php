<?php

class Answer {

    // Database connection and table name
    private $conn;
    private $table_name = "answers";


    public $answerId;
    public $QuestionId;
    public $OptionId;


// Constructor to initialize database connection
    public function getDbOn($db){
        $this->conn = $db;
    }

    private function checkAnswer($QuestionId, $OptionId){
        $query = "SELECT * FROM ". $this->table_name ." WHERE QuestionId = ?  AND OptionId = ?  ;";
        $stmt  = $this->conn->prepare($query);
        $stmt->bind_param("ii",$QuestionId , $OptionId);
        
        if(!$stmt->execute()){
            //TODO:error page
            return false;
        }
        $results = $stmt->get_result();
        $count  = $results->num_rows;
        return $count>0;
    } 
   
    public function processAnswers($submittedAnswers){
        $score = 0;
        foreach($submittedAnswers as $ans){
            $qid = $ans["QuestionId"];
            $oid = $ans["OptionId"];
            $evaluation = $this->checkAnswer($qid , $oid);
            if($evaluation){
                $score++;
            }
        }
        return $score;
    }

}


?>