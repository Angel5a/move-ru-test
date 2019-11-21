<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include ('classes/Angel5a/autoload.php');

if (empty($argv[1])) {
    die("Usage: $argv[0] <URL>\n");
}
$url = $argv[1];

$text = @file_get_contents($url);
$tokenizer = new Angel5a\MoveRuTest\HtmlTokenizer($text);
$counter = new Angel5a\MoveRuTest\TagCounter($tokenizer);
$tagCounts = $counter->getTagCounts();

echo "File: $url\n";

foreach ($tagCounts as $name=>$count) {
    echo "$name\t\t$count\n";
} /* $tagCounts */ 
