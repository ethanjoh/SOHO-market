<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$sql = "SELECT * FROM offer WHERE num = '$oid' ";
$res = mysqli_query($connect, $sql);
$row = mysqli_fetch_array($res);

//공급업체 정보, 수수료 가져오기
$sql1 = "SELECT * FROM supplier WHERE id='$row[id]' ";
$result1 = mysqli_query($connect, $sql1);
$sp_row = mysqli_fetch_array($result1); 	

//상품 카테고리 정보 가져오기
$sql2 = "SELECT * FROM products_category1 WHERE id='$sp_row[id]' AND hide='N'";
$result2 = mysqli_query($connect, $sql2);
$ca_row = mysqli_fetch_array($result2);  

$a_goods_fk = explode(",", $row['goods_fk']);
$mod_volume = explode(",", $row['mod_count']); //입고수량	
$option = explode(",", $row['goods_kind']); //옵션정보

$contents = "<p>아래 상품들이 입고예정입니다.<br>";
$contents .= "입고예정 공지 이후 최대 2~3일 이내(주말 제외)에 입고예정입니다.<br>";
$contents .= "입고예정에 포함되어 있더라도 제조사의 사정에 의해 일부품목의 입고가 안될 수 있습니다.</p>";
$contents .= "<p><font color=\"red\">입고예정을 참고하시고, 가급적 입고문의 등은 자제부탁드립니다.</font></p>";


//물건 정보를 불러옵니다.
for($i=0; $i<sizeof($a_goods_fk); $i++){
 		$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
 		$pro_result = mysqli_query($connect, $pro_sql);
 		$pro_row = mysqli_fetch_array($pro_result);

    if($mod_volume[$i] != "0") {
      $goods_name = "<a href=\"http://www.".$_SERVER[SERVER_NAME]."/shop/detail.php?pnum=".$pro_row['num']."&amp;lcode=".$pro_row['category_l']."&amp;mcode=".$pro_row['category_m']."&amp;scode=".$pro_row['category_s']."\" target=\"_blank\">".$pro_row['name'];
     
      if($option[$i]) {
        $option2 = explode("(", $option[$i]);
        $goods_name .= " - ".$option2[0]."</a><br>";
      }
      else 
        $goods_name .= "</a><br>";

    }


    $contents .= $goods_name;
}

$code = "notice"; //공지게시판 코드
$id = "admin";
$title = "[".$ca_row['name']."] 입고예정 알림";
$name = "관리자";

//글 작성 시 암호는 어드민 게시판 관리자 암호를 자동입력
$query = "SELECT * FROM code WHERE code='$code' ";
$result = mysqli_query($connect, $query);
$mrow = mysqli_fetch_array($result);
$passwd = $mrow['passwd'];

          
//main_no는 자동증가하므로 공백 입력
//depth 필드도 현재는 필요없으므로 삽입하지 않아야 기본값 0으로 세팅된다.
//첨부파일이 없다면 filename 필드는 추가를 하지 않아야 기본 NULL 값으로 된다.
//DB 작성 시 filename 은 기본값 NULL 로 지정.
$board = 'bbs_'.$code;
$sql = "INSERT INTO $board ( main_no, id, title, name, contents, passwd, date, mod_date, count, email )
                    VALUES ( '', '$id', '$title', '$name', '$contents', '$passwd', now(), now(), '0', '$email')";


$result = mysqli_query($connect, $sql);

$url = "view_offer.php?oid=".$oid;


if($result) {   
  show_msg('공지글을 작성했습니다.', $url);
}else {
  show_msg($errmsg, $url);
}

?>
