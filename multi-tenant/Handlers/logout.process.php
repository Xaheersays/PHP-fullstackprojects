<?php
    session_start();
    session_destroy();
    header("Location: /multi-tenant/Views/register.page.php");
    exit;
?>