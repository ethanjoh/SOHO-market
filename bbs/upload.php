<?php
//there are enough examples around to handle the upload...
//the only important difference is the error reporting and the starting of the next form upload...
//presume $uploadOk is a boolean that is true if the upload succeeds; false if it fails...
//note the use of "parent" in the outputted javascript... the script is outputted into the CSR iFrame... therefor it needs parent to acces dom objects and javascript of the main page.

$currentFormId = $_POST['formId'];
$nextFormId = $_POST['formId'] + 1;

echo "<script type=\"javascript\">";

//change the content of your loader div to a desired image
if($uploadOk){
    echo "parent.loader_{$currentFormId}.innerHTML = 'uploadOk.gif';";
} else {
    echo "parent.loader_{$currentFormId}.innerHTML = 'uploadNotOk.gif';";
}

//submit the next form... the javascript function will only perform it if the form exists.
echo "parent.upload(document.form_{$nextFormId}, document.loader_{$nextFormId});";

echo "</script>";

?>
