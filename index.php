<?php

$questionNumbers = 0;

foreach ($_POST as $key => $answer) {
    setcookie($key, $answer, time() + 60 * 60);
    $_COOKIE[$key] = $answer;
}
print_r($_COOKIE);

function checkIfPreviouslySelected($key, $selected) {
    if (isset($_COOKIE[$key]) and $_COOKIE[$key] == $selected) {
        return "checked";
    }
    return "";
}

function printInputs($title, $one, $x, $two, $key, $correctAnswer) {
        $results = checkQuestionMessage($key, $correctAnswer);
        $GLOBALS["questionNumbers"]++;
        echo "<h3>Fråga ".$GLOBALS["questionNumbers"].": $title</h3>";
        echo "<input type='radio' name='$key' value='1' ".checkIfPreviouslySelected($key, "1")." />1. $one";
        echo "<input type='radio' name='$key' value='x' ".checkIfPreviouslySelected($key, "x")."/>X. $x";
        echo "<input type='radio' name='$key' value='2' ".checkIfPreviouslySelected($key, "2")."/>2. $two";
        echo "<p>$results</p>";
        
        return checkQuestionScore($key, $correctAnswer);
}

function checkQuestionScore($key, $correct) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return 0;
    }
    if (isset($_POST[$key])) {
        if ($_POST[$key] == $correct) {
            return 1;
        }
    } 
    return 0;
}

function checkQuestionMessage($key, $correct) {
    if ($_SERVER["REQUEST_METHOD"] != "POST") {
        return "";
    }
    if (isset($_POST[$key])) {
        if ($_POST[$key] == $correct) {
            return "Du svarade '".$_POST[$key]."', det var RÄTT";
        }
        else {
            return "Du svarade '".$_POST[$key]."', det var FEL";
        }
    } else {
        return "Du svarade inget, det var FEL";
    }
}
?>
    
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <form method="POST">
        <?php
            $countOfCorrectAnswer = printInputs("Hur många koffeintabletter är lagom?", "En tablett", "Två st", "treee", 'question1', "x");
            $countOfCorrectAnswer += printInputs("Vem heter mest göteborsk??", "Glen", "Inte Gleeen", "Inte glen", 'question2', "1");
            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                echo "<br/><br/>";
                echo "Antal rätt: <b>".$countOfCorrectAnswer ." / ".$GLOBALS["questionNumbers"]."</b>";
            }
            echo "<br/><br/>";
        ?>
        <button type="submit"/>Skicka formuläret</button>
    </form>    
</body>
</html>