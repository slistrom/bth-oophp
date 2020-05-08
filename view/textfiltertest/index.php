<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());


?><h1>Testing some textfilters</h1>

<h2>Testing bbcode filter</h2>
<h3>Source:</h3>
<pre><?= wordwrap(htmlentities($bbcodeText)); ?></pre>
<h3>HTML output after using filter bbcode (source):</h3>
<pre><?= wordwrap(htmlentities($bbcodeHtml)); ?></pre>
<h3>HTML output after using filter bbcode (including nl2br()):</h3>
<?= $bbcodenl2br ?>

<h2>Testing clickable filter</h2>
<h3>Source:</h3>
<pre><?= wordwrap(htmlentities($clickableText)); ?></pre>
<h3>HTML output after using filter clickable (source):</h3>
<pre><?= wordwrap(htmlentities($clickableHtml)); ?></pre>
<h3>HTML output after using filter clickable:</h3>
<?= $clickableHtml ?>

<h2>Testing markdown filter</h2>
<h3>Source:</h3>
<pre><?= $mdText; ?></pre>
<h3>HTML output after using filter markdown (source):</h3>
<pre><?= htmlentities($mdHtml); ?></pre>
<h3>HTML output after using filter markdown:</h3>
<?= $mdHtml ?>
