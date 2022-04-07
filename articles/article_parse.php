<?php
use Yaml;

$file = readfile('./test_article.yml');

$parsed = Yaml::parse($file);
var_dump($parsed);


?>