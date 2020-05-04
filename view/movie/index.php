<?php

namespace Anax\View;

/**
 * Render content within an article.
 */

// Show incoming variables and view helper functions
//echo showEnvironment(get_defined_vars(), get_defined_functions());

?><h1>Welcome to the moviedatabase</h1>
<div class="moviemenu">
    <span class="menuoption"><a href="movie/movies">Show all movies</a></span> |
    <span class="menuoption"><a href="movie/search-title">Search movie titles</a></span> |
    <span class="menuoption"><a href="movie/search-year">Search movie years</a></span> |
    <span class="menuoption"><a href="movie/movie-select">Select movie</a></span> |
    <span class="menuoption"><a href="movie/reset">Reset</a></span>
</div>
<p> On this page you will find a lot of wonderful information about your favourite movies. Choose what you want to do in the menu above.</p>
