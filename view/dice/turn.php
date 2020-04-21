<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>
<?php if ($winner == null) : ?>
    <?php if ($turn == "player") : ?>
        <h2>Player turn</h2>

        <?php if ($badroll == false) : ?>
            <form method="post" action="playerroll" >
                <input type="submit" class="button" name="roll" value="Roll dice">
            </form>
            <br>
            <?php if ($sum != 0) : ?>
                <form method="post" action="save" >
                    <input type="submit" class="button" name="save" value="Save score">
                </form>
            <?php endif; ?>
        <?php else : ?>
            <form method="post" action="save" >
                <input type="submit" class="button" name="save" value="Continue">
            </form>
            <p>You rolled a 1 and will not get any points this turn.</p>
        <?php endif; ?>
        <p>Turn score : <?= $sum ?> </p>
        <?php if ($values != null) : ?>
            <p class="dice-utf8">
            <?php foreach ($values as $value) : ?>
                <i class="dice-<?= $value ?>"></i>
            <?php endforeach; ?>
            </p>
        <?php endif; ?>

    <?php else : ?>
        <h2>Computer turn</h2>
        <?php if ($sum == 0) : ?>
            <form method="post" action="computerroll" >
                <input type="submit" class="button" name="roll" value="Roll for computer">
            </form>
        <?php else : ?>
            <form method="post" action="save" >
                <input type="submit" class="button" name="save" value="Go to player turn">
            </form>
            <p>Computer rolled three times and got a score of <?= $_SESSION["sum"] ?></p>
            <?php if ($badroll == true) : ?>
                <p>However the computer rolled a 1 and will not get any points this turn.</p>
            <?php endif; ?>
        <?php endif; ?>
    <?php endif; ?>
<?php else : ?>
    <p><a href="init">Play one more time</a></p>
<?php endif; ?>