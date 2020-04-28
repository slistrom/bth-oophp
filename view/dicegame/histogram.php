<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?>

<?php if ($histogram->getAsText() != "") : ?>
    <p>Game histogram:</p>
    <pre><?= $histogram->getAsText() ?></pre>
<?php endif; ?>

