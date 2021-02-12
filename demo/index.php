<?php
require_once "../src/DummyFileGenerator.php";

use CodeCauldron\Tools\File\DummyFileGenerator;

?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dummy File Generator Demo</title>
</head>
<body>
<h1>Dummy File Generator Demo</h1>
<p>
    Click the buttons below to create and download a zipped dummy file of that size.
</p>
<p>
    Note that the 250GB dummy file will not be created since the largest file our generator currently allows is 200MB.
    This behavior can be edited in <i>DummyFileGenerator.php</i>.
</p>
<form action="download.php" method="post">
    <input type="hidden" name="size" value="100"/>
    <input type="hidden" name="unit" value="<?php echo DummyFileGenerator::B ?>"/>
    <button type="submit">100B</button>
</form>

<form action="download.php" method="post">
    <input type="hidden" name="size" value="255"/>
    <input type="hidden" name="unit" value="<?php echo DummyFileGenerator::KB ?>"/>
    <button type="submit">255kB</button>
</form>

<form action="download.php" method="post">
    <input type="hidden" name="size" value="1"/>
    <input type="hidden" name="unit" value="<?php echo DummyFileGenerator::MB ?>"/>
    <button type="submit">1MB</button>
</form>

<form action="download.php" method="post">
    <input type="hidden" name="size" value="250"/>
    <input type="hidden" name="unit" value="<?php echo DummyFileGenerator::GB ?>"/>
    <button type="submit">250G</button>
</form>
</body>
</html>