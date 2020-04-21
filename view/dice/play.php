<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Play throw dice 100</h1>

<p> This game is about reaching the score 100 first.<br>
You will be playing against a computer. Each turn you get to roll two dices.<br>
If you get a dice with number 1 you lose the score for this round.<br>
If you get two dices with other numbers than 1 you can choose to continue rolling<br>
or stop and save this rounds score to your total score.</p>

<?php if ($winner == "player") : ?>
    <p>Player won with <?= $player_score ?></p>
<?php elseif ($winner == "computer") : ?>
    <p>Computer won with <?= $computer_score ?></p>
<?php else : ?>
    <p>Player total score: <?= $player_score ?><br>
    Computer total score: <?= $computer_score ?></p>
<?php endif; ?>
