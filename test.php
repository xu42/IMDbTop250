<?php

include 'top250.class.php';
$test = new top250();
$rs = $test->getPoster('tt0071562');

print_r($rs);

?>
