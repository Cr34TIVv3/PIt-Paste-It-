<?php

// session_start();

$array = $_SESSION['toTransfer'];

$keys = array_keys($array);
$output = implode(",", $keys);
$output .= PHP_EOL;

$values = array_values($array);
$output .= implode(",", $values);

echo $output;

?>