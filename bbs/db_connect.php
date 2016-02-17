<?

$connect = mysqli_connect("localhost","","") or die('Could not connect: ' . mysql_error());
mysqli_select_db($connect, "") or die( "Unable to select database");
 
?>
