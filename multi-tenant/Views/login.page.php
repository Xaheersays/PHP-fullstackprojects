<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
        
</head>
<body class="bg-slate-800 h-screen flex items-center justify-center">

        <?php
            
            session_start();
            $message="";
            if(isset($_SESSION["message"])){
                $message = $_SESSION["message"];
            }
        ?>
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Login Form</h2>
        <?php
            if ($message !== "") {
                echo '<p class="bg-yellow-500 p-4 rounded-md my-2">' . htmlspecialchars($message) . '</p>';
            }
        ?>
       
        <form action="../Handlers/login.process.php" method="POST">



            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                <input type="email" id="email" name="email" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>



            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700">Password</label>
                <input type="password" id="password" name="password" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>

            <div class="mb-4">
                <label for="organisation" class="block text-sm font-medium text-gray-700">Organisation</label>
                <input type="organisation" id="organisation" name="organisation" required
                       class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
            </div>



            <div>
                <button type="submit"
                        class="w-full mb-4 flex justify-center py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
                    Login
                </button>
                <span class="mt-10">Not Registered Yet ? <a class="text-blue-500" href="./register.page.php">login</a></span>

            </div>


        </form>
    </div>
</body>
</html>