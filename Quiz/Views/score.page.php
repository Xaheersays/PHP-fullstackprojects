<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Result</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<?php
        session_start();

        if(!isset($_SESSION["username"])){
            header("Location: /Quiz/Views/login.page.php"); 
            
            exit;
        }


        $score = 0;
        $maxMarks = 0;
        if (isset($_SESSION['score']) && isset($_SESSION['maxMarks'])) {
                $score = $_SESSION['score'];
                $maxMarks = $_SESSION['maxMarks'];
        }else{
            header("Location: /Quiz/Views/takeQuiz.page.php");
            exit;
        }

        

?>

<body class="bg-slate-800 flex items-center justify-center h-screen">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-md w-full">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-4">Congratulations!</h1>
        <p class="text-gray-700 text-center mb-8">You have completed the quiz.</p>
        <div class="text-center">
            
            <p class="text-yellow-800 font-bold">Attempt no : <?php  echo $_SESSION["attemptNo"] ?></p>

            <p class="text-2xl font-bold text-green-600 mb-4">Your Score:
                 <span id="score">   <?php echo $score ; ?>       </span> 
                / <?php echo $maxMarks ; ?>
        </p>
            <p class="text-gray-700">Well done! Keep up the good work.</p>
        </div>
        <div class="text-center mt-8">
            <a href="../index.php" class="bg-indigo-600 text-white px-4 py-2 rounded shadow hover:bg-indigo-700 transition">Go to Home</a>
        </div>
    </div>

    <?php 
        session_destroy();
    ?>

</body>
</html>
