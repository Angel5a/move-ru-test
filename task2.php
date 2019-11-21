<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

/**
 * Swap $arr[0] and $arr[$num] items.
 * This is the part of the task.
 * 
 * @param  array  &$arr  Target array.
 * @param  int    $num   Index of the element to swap with.
 */
function array_swap(array &$arr, int $num) {
    $tmp = $arr[$num];
    $arr[$num] = $arr[0];
    $arr[0] = $tmp;
}

/**
 * Sort an array of integers in ascending order.
 * Simple way (without callback).
 * 
 * @param  array  $arr  Input array.
 * @return array  Array sorted in ascending order.
 */
function array_sort_asc_with_swap_simple(array $arr) {
    for ($cnt = count($arr); $cnt > 1; $cnt--) {
        for ($i = 1; $i < $cnt; $i++) {
            if ($arr[$i] > $arr[0]) {
                array_swap($arr, $i);
            }
            array_swap($arr, $cnt - 1);
        }
    }
    return $arr;
}

/**
 * Sort an array of integers using callback to compare.
 * This is more common to use different rules to compare,
 * so something like this has to be done.
 * 
 * @param  array  $arr  Input array.
 * @param  callable  $cmp  Callback to compare elements.
 * @return array  Array sorted according to compare method.
 */
function array_sort_with_swap_callback(array $arr, callable $cmp) {
    for ($cnt = count($arr); $cnt > 1; $cnt--) {
        for ($i = 1; $i < $cnt; $i++) {
            if (call_user_func($cmp, $arr[$i], $arr[0]) > 0) {
                array_swap($arr, $i);
            }
            array_swap($arr, $cnt - 1);
        }
    }
    return $arr;
}

/**
 * Sort an array of integers using callback to compare.
 */
function array_sort_asc_with_swap(array $arr) {
    return array_sort_asc_with_swap_simple($arr);
    //return array_sort_with_swap_callback($arr, function (int $a, int $b) { return $a <=> $b; });
}

$tests = [
    [4, 5, 8, 9, 1, 7, 2],
    [0, 1, 2, 3, 4, 5, 6, 7, 8, 9],
    [9, 8, 7, 6, 5, 4, 3, 2, 1, 0],
    [5, 2],
    [3],
    [],
];

?>
<html>
<head>
    <title>Task 2</title>
</head>
<body>
<h1>Task 2</h1>
    <p>Sort array using array_swap.</p>
    <?php foreach ($tests as $input) : ?>
        <?php $output = array_sort_asc_with_swap($input); ?>
        <div class="block">
            <div class="header">Input</div>
            <div class="content"><?= join(', ', $input); ?></div>
        </div>
        <div class="block">
            <div class="header">Result</div>
            <div class="content"><?= join(', ', $output); ?></div>
        </div>
    <?php endforeach; /* $tests */ ?>
</body>
</html>