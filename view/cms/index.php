<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><h1>Welcome to the CMS admin page</h1>
<div class="moviemenu">
    <span class="menuoption"><a href="cms/content">Show all content</a></span> |
    <span class="menuoption"><a href="cms/create">Create new</a></span> |
    <span class="menuoption"><a href="cms/admin">Edit cms database</a></span> |
    <span class="menuoption"><a href="cms/pages">View pages</a></span> |
    <span class="menuoption"><a href="cms/blogs">View blogs</a></span> |
    <span class="menuoption"><a href="cms/reset">Reset database</a></span>
</div>
<p>Click on the links above to view or edit the CMS content.</p>
