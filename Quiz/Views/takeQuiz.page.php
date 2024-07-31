<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        
        .question-container {
            max-height: 80vh; 
            overflow-y: auto; 
        }
    </style>
</head>
<?php
    session_start();
    require_once '../Config/database.php';
    require_once '../Objects/Questions.php';
    require_once '../Objects/Options.php';

    $database = new Database(); 
    $db = $database->getConnection(); 

    $ques = new Questions();
    $ques->getDbOn($db);

    $ops = new Options();
    $ops->getDbOn($db);

    $questionList = $ques->prepareQuestions(5)["data"];
    $questionAndOptions = $ops->prepareQuestionAndOptions($questionList); 


   if( ! isset($_SESSION['userId']) || !isset($_SESSION["username"]) ){
        header("Location: /Quiz/Views/login.page.php");
        exit;
   }
?>

<body class="bg-slate-800 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-2xl w-full">
        <h1 class="text-2xl font-bold mb-6 text-gray-800">Quiz</h1>


        <form action="/Quiz/Handlers/quiz.process.php" method="POST">
            <div class="question-container">
                <?php foreach ($questionAndOptions as $item): ?>
                    <div class="mb-6">
                        <h2 class="text-xl font-semibold text-gray-700"><?php echo htmlspecialchars($item["question"]["QuestionTitle"]); ?></h2>
                        <p class="text-gray-600"><?php echo htmlspecialchars($item["question"]["QuestionDescription"]); ?></p>
                        
                        <?php foreach ($item["options"] as $option): ?>
                            <div class="mt-2">
                                <label class="flex items-center space-x-2">
                                    <input type="radio" name="question_<?php echo $item["question"]["QuestionId"]; ?>" value="<?php echo $option["OptionId"]; ?>" required>
                                    <span><?php echo htmlspecialchars($option["OptionDescription"]); ?></span>
                                </label>
                            </div>
                        <?php endforeach; ?> 
                    </div>
                <?php endforeach; ?>
            </div>

            <button type="submit" class="w-full py-2 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700">
                Submit
            </button>
        </form>
    </div>
</body>
</html>
