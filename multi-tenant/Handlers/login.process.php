<?php
    require_once "../Config/database.php";
    require_once "../Objects/Users.php";

    session_start();
    if($_SERVER["REQUEST_METHOD"]!=="POST"){
        header("Location: /multi-tenant/Views/login.page.php");
        exit;
    }

    $email = $_POST["email"];
    $inputPassword = $_POST["password"];
    $organisation = $_POST["organisation"];

    
    if(empty($email) ||  empty($inputPassword) || empty($organisation)){
        $_SESSION["message"] = "please fill out all the fields";
        header("Location: /multi-tenant/Views/login.page.php");
        exit;
    }

    $database = new Database();
    $db= $database->getConnection();
    $usr = new Users("","","","","","");
    $usr->getDbOn($db);

    $authResults = $usr->autheticate($email,$inputPassword,$organisation);

    if(!$authResults["success"]){
        $_SESSION["message"] = $authResults["message"];
        header("Location: /multi-tenant/Views/login.page.php");
        exit;
    }

    $_SESSION["message"] = $authResults["message"];


    $_SESSION["email"] =  $authResults["data"]["email"];
    $_SESSION["organisation"] =  $authResults["data"]["organisation"];
    $_SESSION["firstName"] = $authResults["data"]["firstName"];
    $_SESSION["lastName"]  = $authResults["data"]["lastName"];
    
    header("Location: /multi-tenant/Views/welcome.page.php");
    exit;    

?>