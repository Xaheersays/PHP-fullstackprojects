<?php
session_start();
require_once "../Objects/Answers.php";
require_once "../Config/database.php";
require_once "../Objects/Users.php";
require_once "../Objects/Scores.php";


if(!isset($_SESSION['username'])){
    header("Location: /Quiz/Views/login.page.php");
    exit;
}

$UserName = $_SESSION['username'];


if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $submittedData = [];

    foreach ($_POST as $key => $value) {

        if (strpos($key, 'question_') === 0) {

            $questionId = str_replace('question_', '', $key);
            $optionId = $value;
            
            $submittedData[] = [
                'QuestionId' => (int)$questionId,
                'OptionId' => (int)$optionId
            ];
        }
    }


    //process answers

    $database = new Database();
    $db = $database->getConnection(); 

    

    $answer = new Answer();
    $answer->getDbOn($db);

    $usr = new Users("","");
    $usr->getDbOn($db);

    $userInfo = $usr->findUserByUserName($UserName);
    if(!$userInfo["success"]){
        header("Location: /Quiz/Views/register.page.php");
        exit;
    }

    $userId = $userInfo["data"]["UserId"];




    $score = $answer->processAnswers($submittedData);

    // $userInfo["data"]["Password"]

    //save score to db

    $sc = new Scores();
    $sc->getDbOn($db);


    $result = $sc->saveScore($userId,$score);

    if(!$result["success"]){
        echo $result["message"];
        exit;
    }


    $_SESSION["score"] = $score;
    $_SESSION["maxMarks"] = count($submittedData);
    header("Location: /Quiz/Views/score.page.php");
    exit;
    
}else{
    echo "error";
}
?>
