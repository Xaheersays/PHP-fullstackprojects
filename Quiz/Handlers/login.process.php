<?php

    session_start();
    require_once "../Config/database.php";
    require_once "../Objects/Users.php";


    $database = new Database();
    $db = $database->getConnection(); 

    //TODO:
    if($_SERVER["REQUEST_METHOD"]!=="POST"){
        // echo "gegete";
        header("Location: /Quiz/index.php");
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new Users($username,$password);
    $user->getDbOn($db);

    $userLoginResults = $user->login($username,$password);
    $_SESSION["message"] = $userLoginResults["message"];


    if(!$userLoginResults["success"]){
        // echo $userLoginResults["message"];
        header("Location: /Quiz/Views/login.page.php");
        exit;
    }



    $userInfo = $user->findUserByUserName($username);
    if(!$userInfo["success"]){
        // echo $userInfo["success"];
        // echo $userInfo["message"];
        header("Location: /Quiz/Views/register.page.php");
        exit;
    }

    $userId = $userInfo["data"]["UserId"];

    $_SESSION["username"] = $username;
    $_SESSION["userId"] = $userId;

    // TODO:$_SESSION["UserId"] = ;
    // echo "logged in";
    header("Location: /Quiz/Views/takeQuiz.page.php");
    exit;


?>