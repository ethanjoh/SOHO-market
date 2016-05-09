<?php

$relativePath = './';
$absolutePath = realpath($relativePath);

echo "<p>상대경로: " . $relativePath . "</p>";
echo "<p>절대경로: " . $absolutePath . "</p>";
