<?php


class Options {

    // Database connection and table name
    private $conn;
    private $table_name = "options";


    public $optionId;
    public $questionId;
    public $optionDescription;


// Constructor to initialize database connection
    public function getDbOn($db){
        $this->conn = $db;
    }

    
    // public function __construct($questionId , $optionDescription) {
    //     $this->questionId = $questionId;
    //     $this->optionDescription = $optionDescription;
    // }
    
    private function getOptions($questionId){

        $query = "SELECT * FROM options WHERE  QuestionId = ? order by rand()";
        $stmt = $this->conn->prepare($query);
        $stmt->bind_param("i", $questionId);
        
        if (!$stmt->execute()) {
            return [ "data" => []];
        }
    
        $result = $stmt->get_result();
        $optionList = [];
        
        while ($row = $result->fetch_assoc()) {
            $optionList[] = $row;
        }
    
        return ["data" => $optionList];
    }
    


    public function prepareQuestionAndOptions($questionList){

        $questionAndOptions = [];
 
        foreach($questionList as $question){
            $res = $this->getOptions($question["QuestionId"]) ;
            $questionAndOptions[] = [
                "question" => $question,
                "options" => $res["data"]
            ];
        }
        
        return $questionAndOptions;

    }

}


?>