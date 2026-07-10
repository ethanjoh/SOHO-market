<?php

include "../util/config.php";
// 각종 유틸함수
include "../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

// 이름과 아이디에 해당되는 세션이 존재하는지 확인
if(!isset($_SESSION["p_id"]) || !isset($_SESSION["p_name"])){
  err_msg('로그인 정보가 없습니다. 다시 로그인해 주세요.');
}

//메타정보
$info_query = "SELECT * FROM admin_setup";
$info_res = mysqli_query($connect, $info_query);
$info = mysqli_fetch_array($info_res);
?>
<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<meta name="keywords" content="<?=$info['keywords']?>" />
<meta name="description" content="<?=$info['description']?>" />
<title><?=$info['site_name']?></title>
<link rel="stylesheet" type="text/css" href="../css/shop_layout.css" />
<script language="JavaScript" src="../js/global.js"></script>
<script language="JavaScript" src="../js/member.js"></script>
<script language="JavaScript" type="text/JavaScript">
<!--

 function form_delete(){
  var form = document.form1;
  var b=0;
     for (i=0; i < form.elements.length; i++) {
		 if (form.elements[i].name =="mnum[]") {
            if (form.elements[i].checked == true) {
			  b++;
			 }
	     }
	 }
	
	if(b == 0) {
	 alert("적어도 하나의 항목은 선택하셔야 합니다.");
	     return;
    }
   form.gb.value="2";

   ret = confirm('삭제하시겠습니까?');
   if(ret) {
   	form.submit();
   }   
  }

//-->
</script>
</head>
<body>
<div id="wrapper">
  <?php  
//상단 메뉴 부분을 파일에서 불러옵니다.
include '../include/top_menu.php';  
?>
  <div id="bodyblock">
    <div id="content">
      <form method='post' name="form1" action="del_msg.php">
        <input type="hidden" name="gb">
        <table summary="message box">
          <tbody>
            <tr>
              <td><a href="check_msg.php">받은 쪽지함</a> | <b>보낸 쪽지함</b> | <a href="new_msg.php">쪽지 쓰기</a> </td>
            </tr>
          </tbody>
        </table>
        <table summary="body">
          <thead>
            <tr class="odd">
              <th width="10%">선택</th>
              <th width="17%">받는 사람</th>
              <th width="42%">메시지</th>
              <th width="12%">확인유무</th>
              <th width="19%">보낸시간</th>
            </tr>
          </thead>
          <?
    $a_re_chk['Y'] = "<img src=\"../images/email_open.png\" alt=\"확인\" />";  
	$a_re_chk['N'] = "<img src=\"../images/email.png\" alt=\"미확인\" />";

	$query = "select mnum from message_info
	          where sendid_fk = '$_SESSION[p_id]' And 
			        send_del = 'N' ";
	$result = mysqli_query($connect, $query);
	$total_bnum = mysqli_num_rows($result);
	mysqli_free_result($result);

	 if(!$page){
		$page = 1;
	 }
   
	 $p_scale=5;

	 $cpage = intval($page);
	 $totalpage = intval($total_bnum/$p_scale);
     if ($totalpage*$p_scale != $total_bnum)
		$totalpage = $totalpage + 1;
					  
     if ($cpage ==1) {
	    $cline = 0 ;
	 } else {
	     $cline = ($cpage*$p_scale) - $p_scale ;
	 } 
						
	 $limit=$cline+$p_scale;
						
	 if ($limit >= $total_bnum) 
		$limit=$total_bnum;

	  $p_scale1 = $limit - $cline;

	  $query2 = "SELECT * FROM message_info
	             		WHERE sendid_fk = '$_SESSION[p_id]' 
						AND send_del = 'N'
		  	     		ORDER BY mnum DESC LIMIT $cline,$p_scale1";
	  $result2 = mysqli_query($connect, $query2);
	  
	  for($i=0; $rows2 = mysqli_fetch_array($result2); $i++){
	  	$bunho = $total_bnum - ($i + $cline) + 1;
	   	//$msg_char = shortenStr($rows2[message],30);
		$msg_char = cut_string_utf8($rows2['message'], 20, "..."); //UTF-8 처리
 ?>
          <tbody>
            <tr>
              <td><input type="checkbox" name="mnum[]" value="<?=$rows2['mnum']?>"></td>
              <td><?=$rows2['receiveid_fk']?>
                &nbsp; </td>
              <td class="left"><a href="read_msg.php?mnum=<?=$rows2['mnum']?>&gb=2">
                <?=$msg_char?>
                </a> </td>
              <td><?=$a_re_chk[$rows2['receive_chk']]?></td>
              <td><?=$rows2['send_reg']?></td>
            </tr>
            <?
	 }  
	 mysqli_free_result($result2);
    ?>
          </tbody>
        </table>
        <table summary="button">
          <tbody>
            <tr>
              <td width="27%"><div class="full"><a class="button" href="javascript:form_delete()" onclick="this.blur();"><span>삭제</span></a> </div></td>
              <td><?
		 $url = "sent_msg.php?gb=2"; 
	  	 page_avg($totalpage,$cpage,$url); 
		 ?>
              </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <!-- content end -->
  </div>
  <!-- bodyblock end -->
  <!-- copyright -->
  <?php
include '../include/bottom.php';
?>
  <!-- copyright end -->
</div>
<!-- wrapper end -->
</body>
</html>
