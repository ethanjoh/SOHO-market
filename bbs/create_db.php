<?php
//mySQL 연결
include "../util/util.php";
include "../util/config.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$sql1 = "CREATE TABLE board
(
code varchar(20) NOT NULL,
main_no int(11) NOT NULL AUTO_INCREMENT,
title varchar(30) NOT NULL,
name varchar(20),
content mediumtext,
passwd varchar(20),
date datetime, 
count int(10) default '0',  
email  varchar(40),
reply_no int(11) NOT NULL, 
rel_no int(11) NOT NULL, 
depth int(3) NOT NULL default '0',
filename varchar(255),

PRIMARY KEY (code, main_no)
)";

$sql2 = "CREATE TABLE code
(
code varchar(20) NOT NULL,
title varchar(255),
passwd varchar(20),

PRIMARY KEY (code)
)";

$result1 = mysqli_query($connect, $sql1); 
$result2 = mysqli_query($connect, $sql2); 

if ($result1 == true) {
	echo "board 테이블을 생성했습니다.<br>";
} else {
	echo "board 테이블을 생성 중 에러가 발생했습니다: " . mysqli_error($connect);
}

if ($result2 == true) {
	echo "code 테이블을 생성했습니다.<br>";
} else {
	echo "code 테이블을 생성 중 에러가 발생했습니다: " . mysqli_error($connect);
}

mysqli_close($connect);

?>
