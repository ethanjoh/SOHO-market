<!-- set diff_num and diff_price from retail_price -->
<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

echo "<p>While changing price all of products...please wait</p>";

$sql    = "SELECT num,retail_price FROM products ";
$result = mysqli_query($connect, $sql);

for ($i = 0; $i < $row = mysqli_fetch_array($result); $i++) {
    $diff_num = "1,5,10,50,100";

    $diff_price = ($row['retail_price'] * .7);
    $diff_price .= "," . ($row['retail_price'] * .65);
    $diff_price .= "," . ($row['retail_price'] * .6);
    $diff_price .= "," . ($row['retail_price'] * .55);
    $diff_price .= "," . ($row['retail_price'] * .5);

    $sql2    = "UPDATE products SET diff_num = '$diff_num', diff_price = '$diff_price' WHERE num='$row[num]'";
    $result2 = mysqli_query($connect, $sql2);
    if ($result2) {
        echo $row['num'] . " has changed diff_price done.<br/>";
    }

}
?>

