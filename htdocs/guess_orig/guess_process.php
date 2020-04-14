<?php
/**
 * File starting the Guess game
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

/**
 * A processing a guess and then redirect back to index.
 */

if ($_POST["doGuess"] ?? false) {
    $_SESSION["action"] = "doGuess";
    $_SESSION["guess"] = htmlentities($_POST["guess"]);
} elseif ($_POST["doCheat"] ?? false) {
    $_SESSION["action"] = "doCheat";
    $_SESSION["guess"] = null;
} elseif ($_POST["doInit"] ?? false) {
    $_SESSION["action"] = "doInit";
    $_SESSION["guess"] = null;
}

var_dump($_SESSION);
// Redirect back to index.
$url = "index.php";
header("Location: $url");
