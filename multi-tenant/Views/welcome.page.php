<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php 
    session_start();
    if(!isset($_SESSION["email"]) || !isset($_SESSION["organisation"])){
        header("Location: /multi-tenant/Views/login.page.php");
        exit;
    }

?>

<body class="bg-slate-800 flex items-center justify-center min-h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full text-center">
        <h1 class="text-4xl font-bold text-gray-800 mb-4">Welcome!</h1>
        <h3> <?php echo $_SESSION["firstName"]." ".$_SESSION["lastName"] ?> </h3>
        <h4><?php echo "From ".$_SESSION["organisation"]." with ".$_SESSION["email"]." email";  ?></h4>

        <p class="text-gray-600 mb-6">We're glad to have you here. Explore our website to learn more about us.</p>
        <form action="../Handlers/logout.process.php">
            <input type="submit" value="logout"  class="inline-block bg-blue-600 text-white px-4 py-2 rounded-md shadow hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
        </form>
    </div>
</body>
</html>
