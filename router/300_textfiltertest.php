<?php
/**
 * Create routes using $app programming style.
 */
//var_dump(array_keys(get_defined_vars()));


/**
 * Test different textfilters.
 */
$app->router->get("textfiltertest/", function () use ($app) {
    $title = "Test textfilters";

    $filter = new \Lii\TextFilter\MyTextFilter();


    // bbcode
    $bbcodeText = file_get_contents(__DIR__ . "/../htdocs/text/bbcode.txt");
    $bbcodeHtml = $filter->parse($bbcodeText, ["bbcode"]);
    $bbcodenl2br = $filter->parse($bbcodeText, ["bbcode", "nl2br"]);

    // clickable
    $clickableText = file_get_contents(__DIR__ . "/../htdocs/text/clickable.txt");
    $clickableHtml = $filter->parse($clickableText, ["link"]);

    // markdown
    $mdText = file_get_contents(__DIR__ . "/../htdocs/text/sample.md");
    $mdHtml = $filter->parse($mdText, ["markdown"]);

    $data = [
        "bbcodeText" => $bbcodeText,
        "bbcodeHtml" => $bbcodeHtml,
        "bbcodenl2br" => $bbcodenl2br,
        "clickableText" => $clickableText,
        "clickableHtml" => $clickableHtml,
        "mdText" => $mdText,
        "mdHtml" => $mdHtml,
    ];

    $app->page->add("textfiltertest/index", $data);
//     $app->page->add("guess/debug");

    return $app->page->render([
        "title" => $title,
    ]);
});
