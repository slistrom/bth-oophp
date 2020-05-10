<?php
if (!$resultset) {
    return;
}
$textFilter = new Lii\Textfilter\MyTextFilter();
?>

<article>
<?php foreach ($resultset as $row) :
    $filters = explode(",", $row->filter);
    array_push($filters, 'strip');
    ?>
<section>
    <header>
        <h1><a href="blog/<?= esc($row->slug) ?>"><?= esc($row->title) ?></a></h1>
        <p><i>Published: <time datetime="<?= esc($row->published_iso8601) ?>" pubdate><?= esc($row->published) ?></time></i></p>
    </header>
    <?= $textFilter->parse($row->data, $filters) ?>
</section>
<?php endforeach; ?>

</article>
