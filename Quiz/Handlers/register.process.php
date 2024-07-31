<?php 
    
    session_start(); 
    require_once "../Config/database.php";
    require_once "../Objects/Users.php";
    
    $database = new Database();
    $db = $database->getConnection(); 
    
    if($_SERVER["REQUEST_METHOD"]!="POST"){
        header("Location: /Quiz/index.php");
        exit;
    }

    $username = $_POST['username'];
    $password = $_POST['password'];
    $user = new Users($username,$password);

    $user->getDbOn($db);
    
    $newUserCreation = $user->createNewUser();
    if($newUserCreation["success"]){
        header("Location: /Quiz/Views/login.page.php?success=true");
        exit;

    }
    $_SESSION["message"]  = $newUserCreation["message"];
    echo $_SESSION["message"];
    header("Location: /Quiz/Views/register.page.php");
    exit;
?>
