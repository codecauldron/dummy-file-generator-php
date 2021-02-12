<?php

require_once "../src/DummyFileGenerator.php";

use CodeCauldron\Tools\File\DummyFileGenerator;

$size = $_POST["size"];
$unit = $_POST["unit"];

$generator = new DummyFileGenerator();
$generator->generateFile($size, $unit);
