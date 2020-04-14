<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("guess/init", function () use ($app) {
    // Init the session for the gamestart
    $game = new Lii\Guess\Guess();
    $_SESSION["game"] = $game;

    return $app->response->redirect("guess/play");
});


/**
 * Play the game - show game status.
 */
$app->router->get("guess/play", function () use ($app) {
    $title = "Play the game";

    // Variables
    $tries = $_SESSION["game"]->tries() ?? null;
    $number = $_SESSION["game"]->number() ?? null;
    $error = $_SESSION["error"] ?? null;
    $_SESSION["error"] = null;
    $res = $_SESSION["res"] ?? null;
    $_SESSION["res"] = null;
    $cheat = $_SESSION["cheat"] ?? null;
    $_SESSION["cheat"] = null;

    $data = [
        "tries" => $tries,
        "action" => $action ?? null,
        "number" => $number,
        "res" => $res,
        "cheat" => $cheat,
        "error" => $error,
    ];

    $app->page->add("guess/play", $data);
//     $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - make a guess.
 */
$app->router->post("guess/make-guess", function () use ($app) {

    // Variables
    $game = $_SESSION["game"];

    try {
        $res = $game->makeGuess((int)$_POST["guess"]);
    } catch (Lii\Guess\GuessException $e) {
        $_SESSION["error"] = $e->getMessage();
    }
    $_SESSION["res"] = $res;


    $app->page->add("guess/play");

    return $app->response->redirect("guess/play");
});

/**
 * Play the game - show cheat.
 */
$app->router->post("guess/cheat", function () use ($app) {

    $_SESSION["cheat"] = true;

    $app->page->add("guess/play");

    return $app->response->redirect("guess/play");
});
