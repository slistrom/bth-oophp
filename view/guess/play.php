<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<h1>Guess my number</h1>

<p>Guess a number between 1 and 100, you have <?= $tries ?> tries left.</p>

<form method="post" action="make-guess" >
    <input type="text" name="guess">
    <?php if ($res === "correct" or $tries === 0) : ?>
        <a href="init">Restart the game</a>
    <?php else : ?>
        <input type="submit" name="doGuess" value="Make a guess">
    <?php endif; ?>
</form>
<p> <form method="post" action="cheat" >
    <input type="submit" name="doCheat" value="Cheat">
</form></p>
<?php if ($res !== null) : ?>
    <p><b>Your guess was <?= $res ?>!</b></p>
<?php endif; ?>

<?php if ($error !== null) : ?>
    <p><b><?= $error ?></b></p>
<?php endif; ?>

<?php if ($cheat !== null) : ?>
    <p>CHEAT: Current number is <?= $number ?></p>
<?php endif; ?>