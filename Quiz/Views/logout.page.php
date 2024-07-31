<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Logout</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-800 flex items-center justify-center h-screen bg-gray-100">
    
    <div class="bg-gray-300 p-6 rounded-lg shadow-lg">
        <form action="/Quiz/Handlers/logout.process.php" method="post">
            <button type="submit"
                    class="text-white bg-red-600 hover:bg-red-700 px-4 py-2 rounded-md text-sm font-medium">
                Logout
            </button>
        </form>
    </div>
</body>
</html>
