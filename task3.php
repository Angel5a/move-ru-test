<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

include ('classes/Angel5a/autoload.php');

$url = isset($_GET['url']) ? $_GET['url'] : basename(__FILE__);

if(!empty($url)) {
    $text = @file_get_contents($url);
    //$text = '<div>Here is <a>a link</a> some <b>bold text</B> and <A>extra link</A>.</div>';
    $tokenizer = new Angel5a\MoveRuTest\HtmlTokenizer($text);
    //$tokenizer = new Angel5a\MoveRuTest\FakeHtmlTokenizer();
    $counter = new Angel5a\MoveRuTest\TagCounter($tokenizer);
    $tagCounts = $counter->getTagCounts();
}
?>
<html>
<head>
    <title>Task 3</title>
<head>
<body>
    <h1>Task 3</h1>
    <p>Count html tags in file.</p>

    <div class="form">
        <form>
            <div class="form-group">
                <label for="url">Url</label>
                <input type="text" class="form-control" id="url" name="url" value="<?= htmlspecialchars($url) ?>" aria-describedby="urlHelp" placeholder="Enter URL">
                <small id="urlHelp" class="form-text text-muted">Enter URL to HTML file.</small>
            </div>
            <button type="submit" class="btn btn-primary">Submit</button>
        </form>
    </div>

    <?php if(!empty($url)) : ?>
        <div class="block">
            <div class="header">File</div>
            <div class="content"><?= htmlspecialchars($url); ?></div>
        </div>
        <div class="block">
            <div class="header">Result</div>
            <div class="content">
                <table class="result_table">
                    <tr><th>Tag name</th><th>Count</th></tr>
                    <?php foreach ($tagCounts as $name=>$count) : ?>
                        <tr>
                            <td><?= htmlspecialchars($name); ?></td>
                            <td><?= htmlspecialchars($count); ?></td>
                        </tr>
                    <?php endforeach; /* $tagCounts */ ?>
                </table>
            </div>
        </div>
    <?php endif; /* $url */ ?>
<body>
</html>