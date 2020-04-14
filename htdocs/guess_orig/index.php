<?php
/**
 * File starting the Guess game
 */

require __DIR__ . "/autoload.php";
require __DIR__ . "/config.php";

// Variables
$game = $_SESSION["game"] ?? null;
$action = $_SESSION["action"] ?? null;

if ($action === "doInit" || $game === null) {
    $game = new Guess();
    $_SESSION["game"] = $game;
} elseif ($action === "doGuess") {
    try {
        $res = $game->makeGuess((int)$_SESSION["guess"]);
    } catch (GuessException $e) {
        $res = $e->getMessage();
    }
}

// Render the page
require __DIR__ . "/view/guess_my_number.php";
