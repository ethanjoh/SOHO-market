<?php

//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>B2B SCM</title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="../css/admin_layout.css" />
<link rel="stylesheet" type="text/css" href="../chrometheme/chromestyle.css" />
<script language="JavaScript" src="../../js/global.js" ></script>
<script language="JavaScript" src="../js/admin.js" ></script>
<script language="JavaScript" src="../js/chrome.js" >
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- tab menu -->
<link rel="stylesheet" type="text/css" href="../css/tabcontent.css" />
<script type="text/javascript" src="../js/tabcontent.js">
/***********************************************
* Tab Content script v2.2- © Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- tab menu end -->
<!-- smart editor -->
<link href="css/default.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="js/HuskyEZCreator.js" charset="utf-8"></script>
<!-- smart editor end -->
<script type="text/javascript">
<!--
function send_mail() {
  var form = document.mail;
  
  oEditors.getById["contents"].exec("UPDATE_IR_FIELD", []);
  form.submit();
 }
 -->
 </script>
</head>
<body>
<!-- wrapper -->
<div id="wrapper">
  <!-- header -->
  <?php
  include "../include/admin_top.php";
  ?>
  <!-- header end -->
  <div id="bodyblock">
    <!-- contents -->
    <div id="content">
      <fieldset class="info">
      <legend><img src="../images/info.png" alt="안내" /> 사용방법</legend>
      <ul>
        <li style="text-align:left">메일 수신을 원한 회원만 표시됩니다.</li>
        <li style="text-align:left">회원 정보에 이메일 주소가 없을 경우 표시되지 않습니다.</li>
      </ul>
      </fieldset>
      <?php

if($mode == 'search'){
  if($id){
    $search_keyword .= " and id = '$id' ";
  }


  if($company_name){
    $search_keyword .= " AND name LIKE '%$name%' ";
  }

}

//회원 테이블의 리스트를 불러옵니다.
$query = "SELECT * FROM pmember WHERE email <> '' AND optin='Y' $search_keyword "; 
$result = mysqli_query($connect, $query);
$total = mysqli_num_rows($result);

?>
      <form name="form1" method="post" action="pmem_sendmail_list.php">
        <input type="hidden" name="mode" value="search" />
        <fieldset>
        <legend>개인회원 찾기</legend>
        <p>
        <label for="id">아이디:</label>
        <input type="text" name="id" value='<?=$id?>' size="20">
        </p>
        <p>
        <label for="company_name">성명:</label>
        <input type="text" name="name" value='<?=$name?>' size="20" >
        </p>
        <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
        <table summary="member list">
          <caption>
          전체 개인회원 메일보내기 (총 회원 수:
          <?=number_format($total)?>
          건 )
          </caption>
          <thead>
            <tr class="odd">
              <th width="9%" scope="col">번호</strong></th>
              <th width="13%" scope="col">아이디</strong></th>
              <th width="12%" scope="col">성명</strong></th>
              <th width="21%" scope="col">담당자 이메일</th>
              <th width="18%" scope="col">가입날짜</th>
              <th width="12%" scope="col"><a href="#" onclick="javascript:checkAll();">선택</a></th>
            </tr>
          </thead>
          <tbody>
            <?php
    if(!$page_scale){
	   $scale=30;
    }
    else if($page_scale == "all"){
	  if($total == 0){
	    $scale = 1;
      }
      else{
	    $scale = $total;
      }
	  $checked = "checked";
    }

    if ($page == ''){
      $page=1;
    }	    

    $cpage = intval($page);
    $totalpage = intval($total/$scale);
    if ($totalpage*$scale != $total)
       $totalpage = $totalpage + 1;
        
    if ($cpage ==1) {
      $cline = 0 ;
    } else {
      $cline = ($cpage*$scale) - $scale ;
	} 
        
	$limit=$cline+$scale;
        
	 if ($limit >= $total) 
       $limit=$total;
 
    $scale1 = $limit - $cline;
				    
	$sql_2 = "select * from pmember where email <> '' $sear_char order by seq_num desc LIMIT $cline,$scale1 "; 
    $result_2 = mysqli_query($connect, $sql_2);
 	for($i=1; $list = mysqli_fetch_array($result_2); $i++){
      
	   $bunho = $total - ( $i + $cline) + 1; 
	   
      if($i%2 == 0)
	      echo "<tr class=odd>\n";	   
 ?>
          <td><?=$bunho?></td>
            <td><a href="javascript:open_win('mem_view_pmember.php?num=<?=$list['seq_num']?>&amp;from=mail','nwin','scrollbars=yes,resizable=yes, width=650,height=650');">
              <?=$list['id']?>
              </a></td>
            <td><?=$list['name']?></td>
            <td><?=$list['email']?></td>
            <td><?=$list['reg_date']?></td>
            <td><input type="checkbox" name="num[]" value="<?=$list['seq_num']?>"></td>
          </tr>
          <?php
    }
    mysqli_free_result($result_2);
  ?>
          </tbody>
          
        </table>
        <table summary="send mail">
          <tbody>
            <tr>
              <td width="20%"><div class="full"><a class="button" href="#" onclick="this.blur();javascript:mail_send();"><span>메일 보내기</span></a></div></td>
              <td width="45%"><?php
	 $url = "pmem_sendmail_list.php?$id=$id&mode=$mode&license_no=$license_no&md_email=$md_email&o_phone=$o_phone&company_name=$company_name&page_scale=$page_scale"; 
	                                                 
 	 page_avg($totalpage,$cpage,$url); 
   ?>
                &nbsp; </td>
              <td width="22%"><input type="checkbox" name="page_scale" value="all" <?=$checked?> onClick="document.form1.submit()">
                한 화면으로 보기 </td>
            </tr>
          </tbody>
        </table>
      </form>
    </div>
    <!-- contens end -->
  </div>
  <!-- bodyblock end -->
  <!-- copyright -->
  <?php
include "../include/admin_bottom.php";
?>
  <!-- copyright  end -->
</div>
<!-- wrapper end -->
</body>
</html>
