<?php
//관리자 인증 파일
include "../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);


$sql1 = "CREATE TABLE products (
  num int(11) NOT NULL auto_increment,
  prod_code varchar(30) NOT NULL default '',
  category_l varchar(5) NOT NULL default '',
  category_m varchar(20) NOT NULL default '',
  name varchar(70) NOT NULL default '',
  company varchar(70) default NULL,
  origin varchar(10) default NULL,
  retail_price varchar(11) default '0',
  sale_price varchar(11) default '0',	
  fixed_price varchar(11) default '0',	
  mileage varchar(7) default NULL,
  opt varchar(100) default NULL,
  con_html char(1) NOT NULL default '',
  contents text,
  s_image enum('Y','N') NOT NULL default 'N',
  s_image_ty varchar(5) default NULL,
  m_image enum('Y','N') NOT NULL default 'N',
  m_image_ty varchar(5) default NULL,
  b_image1 enum('Y','N') NOT NULL default 'N',
  b_image1_ty varchar(5) default NULL,
  b_image2 enum('Y','N') NOT NULL default 'N',
  b_image2_ty varchar(5) default NULL,
  b_image3 enum('Y','N') NOT NULL default 'N',
  b_image3_ty varchar(5) default NULL,
  b_image4 enum('Y','N') NOT NULL default 'N',
  b_image4_ty varchar(5) default NULL,
  b_image5 enum('Y','N') NOT NULL default 'N',
  b_image5_ty varchar(5) default NULL,
  d_image enum('Y','N') NOT NULL default 'N',
  d_image_ty varchar(5) default NULL,					
  created date default NULL,
  option1_chk enum('Y','N') NOT NULL default 'N',
  option2_chk enum('Y','N') NOT NULL default 'N',
  del_chk enum('Y','N') NOT NULL default 'N',
  PRIMARY KEY  (num),
  KEY category_l (category_l)
) TYPE=MyISAM";

$result1 = mysqli_query($connect, $sql1); 

if ($result1 == true) {
	echo "테이블을 생성했습니다.<br>";
} else {
	echo "테이블을 생성 중 에러가 발생했습니다: " . mysql_error();
}

mysql_close($connect);

?>
