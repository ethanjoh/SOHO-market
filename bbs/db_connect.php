<?

$connect = mysqli_connect("localhost","","") or die('Could not connect: ' . mysqli_connect_error());
mysqli_select_db($connect, "") or die( "Unable to select database");
 
?>
