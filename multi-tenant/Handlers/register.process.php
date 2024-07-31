<?php

    require_once "../Config/database.php";
    require_once "../Objects/Users.php";

    //|| !isset($_SESSION["email"])

    if($_SERVER["REQUEST_METHOD"]!=="POST"){
        header("Location: /multi-tenant/Views/login.page.php");
        exit;
    }

    $firstName = htmlspecialchars(trim($_POST['firstName']));
    $lastName = htmlspecialchars(trim($_POST['lastName']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phoneNo = htmlspecialchars(trim($_POST['phoneNo']));
    $organisation = htmlspecialchars(trim($_POST['organisation']));
    $password = htmlspecialchars(trim($_POST['password']));
    $confirmPassword = htmlspecialchars(trim($_POST['confirmPassword']));

    if (empty($firstName) ||
        empty($lastName) ||
        empty($email) || 
        empty($phoneNo) ||
        empty($organisation) || 
        empty($password) ||
        empty($confirmPassword)) {
        $_SESSION['message'] = "All fields are required.";
        header("Location: ../Views/register.page.php"); 
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['message'] = "Invalid email format.";
        header("Location: ../Views/register.page.php");
        exit;
    }

    if ($password !== $confirmPassword) {
        $_SESSION['message'] = "Passwords do not match.";
        header("Location: ../Views/register.page.php");
        exit;
    }

    $database = new Database();
    $db = $database->getConnection();


    $user = new Users($email , $password , $firstName, $lastName , $organisation , $phoneNo );
    $user->getDbOn($db);

    $addUserResult = $user->addUserEntry();

    if(!$addUserResult["success"]){
        $_SESSION["message"] = $addUserResult["message"];
        echo "here4";
        header("Location: /multi-tenant/Views/register.page.php");
        exit; 
    }
    
    $_SESSION['message'] = "Registration successful! You can now login.";
    echo "here5";
    header("Location: ../Views/login.page.php");
    exit;



?>