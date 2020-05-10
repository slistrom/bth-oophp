<?php
    $textFilter = new Lii\Textfilter\MyTextFilter();
    $filters = explode(",", $content->filter);
    array_push($filters, "strip");
?>

<article>
<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Published: <time datetime="<?= esc($content->published_iso8601) ?>" pubdate><?= esc($content->published) ?></time></i></p>
    </header>
    <?= $textFilter->parse($content->data, $filters) ?>
</article>
