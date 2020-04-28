<?php

namespace Lii\Dice;

use Anax\Commons\AppInjectableInterface;
use Anax\Commons\AppInjectableTrait;

// use Anax\Route\Exception\ForbiddenException;
// use Anax\Route\Exception\NotFoundException;
// use Anax\Route\Exception\InternalErrorException;

/**
 * A sample controller to show how a controller class can be implemented.
 * The controller will be injected with $app if implementing the interface
 * AppInjectableInterface, like this sample class does.
 * The controller is mounted on a particular route and can then handle all
 * requests for that mount point.
 *
 * @SuppressWarnings(PHPMD.TooManyPublicMethods)
 */
class DiceController implements AppInjectableInterface
{
    use AppInjectableTrait;



    /**
     * @var string $db a sample member variable that gets initialised
     */
//     private $db = "not active";
//     private $turn = "player";



    /**
     * The initialize method is optional and will always be called before the
     * target method/action. This is a convienient method where you could
     * setup internal properties that are commonly used by several methods.
     *
     * @return void
     */
//     public function initialize() : void
//     {
//         // Use to initialise member variables.
//         $this->db = "active";
//         $this->turn = "computer";
//
//         // Use $this->app to access the framework services.
//     }


    /**
     * This is the index method action, it handles:
     * ANY METHOD mountpoint
     * ANY METHOD mountpoint/
     * ANY METHOD mountpoint/index
     *
     * @return string
     */
    public function indexAction() : string
    {
        // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
        return "Index!";
    }

    /**
     * This is the debug method action, it handles:
     * ANY METHOD mountpoint/debug
     *
     * @return string
     */
    public function debugAction() : string
    {
        // Deal with the action and return a response.
//         return __METHOD__ . ", \$db is {$this->db}";
        return "Debug my game!";
    }

    /**
     * This is the init method action, it handles:
     * ANY METHOD mountpoint/init
     *
     * @return object
     */
    public function initAction() : object
    {
        // Init the session for the gamestart
        $session = $this->app->session;
        $session->set("turn", "player");
        $session->set("playerScore", 0);
        $session->set("computerScore", 0);
        $session->set("badroll", false);
        $session->set("values", null);
        $session->set("sum", 0);
        $session->set("lastComputerRolls", 0);

        $diceHand = new DiceHand(2);
        $session->set("diceHand", $diceHand);

        return $this->app->response->redirect("dicegame/play");
    }

    /**
     * This is the play method action, it handles:
     * ANY METHOD mountpoint/play
     *
     * @return object
     */
    public function playActionGet() : object
    {
        $title = "Play the game";

        //Variables
        $session = $this->app->session;
        $page = $this->app->page;

        $turn = $session->get("turn");
        $playerScore = $session->get("playerScore", 0);
        $computerScore = $session->get("computerScore", 0);
        $values = $session->get("values");
        $sum = $session->get("sum", 0);
        $computerRolls = $session->get("computerRolls", 0);
        $badroll = $session->get("badroll", false);
        $winner = null;
        $diceHand = $session->get("diceHand");
        $histogram = $diceHand->getHistogram();

        if ($playerScore >= 100) {
            $winner = "player";
        } else if ($computerScore >= 100) {
            $winner = "computer";
        }

        $data = [
            "playerScore" => $playerScore,
            "computerScore" => $computerScore,
            "turn" => $turn,
            "values" => $values,
            "sum" => $sum,
            "badroll" => $badroll,
            "winner" => $winner,
            "histogram" => $histogram,
            "computerRolls" => $computerRolls,
        ];

        $page->add("dicegame/play", $data);
        $page->add("dicegame/histogram", $data);
        $page->add("dicegame/turn", $data);
    //     $page->add("dice/debug");

        return $page->render([
            "title" => $title,
        ]);
    }

    /**
     * This is the playerroll method action, it handles:
     * ANY METHOD mountpoint/playerroll
     *
     * @return object
     */
    public function playerrollActionPost() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $diceHand = $session->get("diceHand");
        $diceHand->roll();

        $session->set("badroll", false);
        $session->set("values", $diceHand->values());
        $currSum = $session->get("sum", 0);
        $session->set("sum", $currSum + $diceHand->sum());
        $session->set("badroll", $diceHand->contain(1));
        $session->set("diceHand", $diceHand);

        return $response->redirect("dicegame/play");
    }

    /**
     * Method deciding if the computer should continue rolling the dice.
     * Computer starts with one roll. Every round that is sucecssful computer
     * increases number of throws with one. If the computer fail it decreases its
     * throws with one.
     *
     * @return object
     */
    public function continueRollAction() : bool
    {
        $session = $this->app->session;

        $computerRolls = $session->get("computerRolls");
        $lastComputerRoll = $session->get("lastComputerRoll", "passed");
        $lastComputerRolls = $session->get("lastComputerRolls", 0);

        $result = true;
        $badroll = $session->get("badroll");
        if ($badroll == true) {
            $result = false;
        }
        if ($lastComputerRoll == "failed" and ($computerRolls >= ($lastComputerRolls - 1))) {
            $result = false;
        } elseif ($computerRolls >= ($lastComputerRolls + 1)) {
            $result = false;
        }

        return $result;
    }

    /**
     * This is the computerroll method action, it handles:
     * ANY METHOD mountpoint/computerroll
     *
     * @return object
     */
    public function computerrollActionPost() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;
        $diceHand = $session->get("diceHand");
        $currSum = $session->get("sum", 0);
        $rolling = true;
        $computerRolls = 0;

        while ($rolling) {
            $diceHand->roll();
            if ($diceHand->contain(1)) {
                $session->set("badroll", true);
            }
            $currSum += $diceHand->sum();
            $session->set("sum", $currSum);
            $computerRolls += 1;
            $session->set("computerRolls", $computerRolls);
            $rolling = $this->continueRollAction();
        }

        $session->set("diceHand", $diceHand);
        $session->set("lastComputerRolls", $computerRolls);

        $badroll = $session->get("badroll");
        if ($badroll == true) {
            $session->set("lastComputerRoll", "failed");
        } else {
            $session->set("lastComputerRoll", "passed");
        }

        return $response->redirect("dicegame/play");
    }

    /**
     * This is the reset method action, it handles:
     * ANY METHOD mountpoint/reset
     *
     * @return object
     */
    public function resetActionGet() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $session->set("badroll", false);
        $session->set("values", null);
        $session->set("sum", 0);

        return $response->redirect("dicegame/play");
    }

    /**
     * This is the save method action, it handles:
     * ANY METHOD mountpoint/save
     *
     * @return object
     */
    public function saveActionPost() : object
    {
        $session = $this->app->session;
        $response = $this->app->response;

        $turn = $session->get("turn");
        $badroll = $session->get("badroll");
        $sum = $session->get("sum");
        $playerScore = $session->get("playerScore");
        $computerScore = $session->get("computerScore");

        if ($turn == "player") {
            $_SESSION["turn"] = "computer";
            if ($badroll == false) {
                $playerScore += $sum;
                $session->set("playerScore", $playerScore);
            }
            return $response->redirect("dicegame/reset");
        } else {
            $session->set("turn", "player");
            if ($badroll != true) {
                $computerScore += $sum;
                $session->set("computerScore", $computerScore);
            }
            return $response->redirect("dicegame/reset");
        };
    }
}
