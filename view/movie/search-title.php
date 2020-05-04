<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

if ($searchTitle != "") {
    $searchTitle = $searchTitle;
}

?><form method="get">
    <fieldset>
    <legend>Search</legend>
    <p>
        <label>Title (use % as wildcard):
            <input type="search" name="searchTitle" value="<?= esc($searchTitle) ?>"/>
        </label>
    </p>
    <p>
        <input type="submit" name="doSearch" value="Search">
    </p>
    <p><a href="movies">Show all</a></p>
    </fieldset>
</form>
