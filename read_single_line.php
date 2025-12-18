<!DOCTYPE html>
<html lang="en">
<?php
$myfile = fopen("webdictionary.txt", "r") or die("Unable to open file!");
echo fgets($myfile);
fclose($myfile);
?>
<body>
    
</body>
</html>