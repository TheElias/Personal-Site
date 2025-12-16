<?php
require __DIR__ . '/vendor/autoload.php';

var_dump(class_exists('Site\\Database'));
var_dump(class_exists('Site\\TokenAuth'));
var_dump(class_exists('Site\\Interfaces\\iTokenAuth'));
?>