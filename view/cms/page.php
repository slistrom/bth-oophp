<?php
    $textFilter = new Lii\Textfilter\MyTextFilter();
    $filters = explode(",", $content->filter);
    array_push($filters, "strip");
?>
<article>
    <header>
        <h1><?= esc($content->title) ?></h1>
        <p><i>Latest update: <time datetime="<?= esc($content->modified_iso8601) ?>" pubdate><?= esc($content->modified) ?></time></i></p>
    </header>
    <?= $textFilter->parse($content->data, $filters) ?>
</article>
