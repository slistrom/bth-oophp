<h1>Guess my number</h>

<p>Guess a number between 1 and 100, you have <?= $_SESSION["game"]->tries() ?> left.</p>

<form method="post" action="guess_process.php" >
    <input type="text" name="guess">
    <input type="submit" name="doGuess" value="Make a guess">
    <input type="submit" name="doInit" value="Start from beginning">
    <input type="submit" name="doCheat" value="Cheat">
</form>

<?php if ($action === "doGuess") : ?>
    <p><b><?= $res ?></b></p>
<?php endif; ?>

<?php if ($action === "doCheat") : ?>
    <p>CHEAT: Current number is <?= $_SESSION["game"]->number() ?></p>
<?php endif; ?>

<!--
<pre>
<?= var_dump($_POST) ?>
<?= var_dump($_SESSION) ?>