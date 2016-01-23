<?
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$m_num = set_var($_GET['m_num']);


$query = "SELECT * FROM member WHERE seq_num='$m_num' ";
$result = mysqli_query($connect, $query);
$rows = mysqli_fetch_array($result);

//마일리지 정보 삭제
$query1 = "SELECT * FROM mileage WHERE id_fk='$rows[id]' ";
$result1 = mysqli_query($connect, $query1);
$rows1 = mysqli_fetch_array($result1);

//회원정보 삭제
$query2 = "DELETE FROM member WHERE seq_num='$m_num' ";
mysqli_query($connect, $query2); 



echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
    <script>
      window.alert('업체정보를 삭제했습니다.')
    </script>
     ";
if($from == "mail") {
	echo  "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
    <script>
      window.close()
    </script>";
}else {
	echo "<meta http-equiv='refresh' content='0; URL=top_member_list.php?page=$page'>";
}
?>
