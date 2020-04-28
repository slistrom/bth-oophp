<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));



/**
 * Init the game and redirect to play the game.
 */
$app->router->get("dice/init", function () use ($app) {
    // Init the session for the gamestart
    $_SESSION["turn"] = "player";
    $_SESSION["player_score"] = 0;
    $_SESSION["computer_score"] = 0;
    $_SESSION["badroll"] = false;
    $_SESSION["values"] = null;
    $_SESSION["sum"] = 0;

    return $app->response->redirect("dice/play");
});


/**
 * Play the game - show game status.
 */
$app->router->get("dice/play", function () use ($app) {
    $title = "Play the game";

    //Variables
    $turn = $_SESSION["turn"];
    $player_score = $_SESSION["player_score"] ?? 0;
    $computer_score = $_SESSION["computer_score"] ?? 0;
    $values = $_SESSION["values"] ?? null;
    $sum = $_SESSION["sum"] ?? 0;
    $badroll = $_SESSION["badroll"] ?? false;
    $winner = null;
    if ($player_score >= 100) {
        $winner = "player";
    } else if ($computer_score >= 100) {
        $winner = "computer";
    }

    $data = [
        "player_score" => $player_score,
        "computer_score" => $computer_score,
        "turn" => $turn,
        "values" => $values,
        "sum" => $sum,
        "badroll" => $badroll,
        "winner" => $winner,
    ];

    $app->page->add("dice/play", $data);
    $app->page->add("dice/turn", $data);
//     $app->page->add("dice/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});

/**
 * Play the game - Roll playerdice.
 */
$app->router->post("dice/playerroll", function () use ($app) {

    $diceHand = new Lii\Dice\DiceHand(2);
    $diceHand->roll();
    $_SESSION["badroll"] = false;
    $_SESSION["values"] = $diceHand->values();
    $_SESSION["sum"] += $diceHand->sum();
    $_SESSION["badroll"] = $diceHand->contain(1);

    return $app->response->redirect("dice/play");
});

/**
 * Play the game - Roll computerdice.
 */
$app->router->post("dice/computerroll", function () use ($app) {

    $diceHand = new Lii\Dice\DiceHand(2);
    for ($x = 0; $x < 3; $x++) {
        $diceHand->roll();
        if ($diceHand->contain(1)) {
            $_SESSION["badroll"] = true;
        }
        $_SESSION["sum"] += $diceHand->sum();
    }

    return $app->response->redirect("dice/play");
});

/**
 * Play the game - Reset session.
 */
$app->router->get("dice/reset", function () use ($app) {

    $_SESSION["badroll"] = false;
    $_SESSION["values"] = null;
    $_SESSION["sum"] = 0;

    return $app->response->redirect("dice/play");
});

/**
 * Play the game - Save score.
 */
$app->router->post("dice/save", function () use ($app) {

    $turn = $_SESSION["turn"];

    if ($turn == "player") {
        $_SESSION["turn"] = "computer";
        if ($_SESSION["badroll"] == false) {
            $_SESSION["player_score"] += $_SESSION["sum"];
        }
        return $app->response->redirect("dice/reset");
    } else {
        $_SESSION["turn"] = "player";
        if ($_SESSION["badroll"] != true) {
            $_SESSION["computer_score"] += $_SESSION["sum"];
        }
        return $app->response->redirect("dice/reset");
    };
});
