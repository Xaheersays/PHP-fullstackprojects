<?php
    session_start();
    session_destroy();
    header("Location: /Quiz/Views/login.page.php");
    exit;
?>