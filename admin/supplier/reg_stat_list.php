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
<script language="JavaScript" src="../../js/global.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/admin.js" type="text/javascript"></script>
<script language="JavaScript" src="../js/chrome.js" type="text/javascript">
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
</script>
<!-- popup calendar -->
<script type="text/javascript" src="../js/datepicker.js"></script>
<link href="../css/datepicker.css" rel="stylesheet" type="text/css" />
<!-- popup calendar end -->
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
      <?php

if($mode == 'search'){
    $search_keyword .= " AND tax_list.reg_date BETWEEN '$date1' AND '$date2' ";
}

//$query = "SELECT * FROM member WHERE 1 $search_keyword ";
$query = "SELECT * FROM supplier, sp_tax_list WHERE supplier.id=sp_tax_list.id AND sp_tax_list.cancel='N' $search_keyword";
$result = mysqli_query($connect, $query);
if($result) {
  $rows = mysqli_fetch_array($result);
  $total = mysqli_num_rows($result);
}  

?>
      <form name="stat" method="get" action="reg_stat_list.php">
        <input type="hidden" name="mode" value="search" />
        <fieldset>
        <legend>날짜 검색</legend>
        <p>
          <label for="sd">시작일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date1" id="sd" value="" size="10" />
          </p>
          <p>
          <label for="ed">종료일 :</label>
          <input type="text" class="w8em format-y-m-d divider-dash highlight-days-67 range-low-2008-01-01 no-transparency" name="date2" id="ed" value="" size="10" />
        </p>
       <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " />
        </fieldset>
      </form>
      <table summary="member list">
        <caption>
        세금계산서 발행리스트
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col" class="member">번호</th>
            <th scope="col" class="member">제목</th>            
            <th scope="col" class="member">발행일자</th>
            <th scope="col" class="member">공급자</th>
            <th scope="col" class="member">품목</th>
            <th scope="col" class="member">발행금액</th>
            <th scope="col" class="member">승인여부</th>
            <th scope="col" class="member">취소</th>
          </tr>
        </thead>
        <tbody>
          <?php
    $scale=30;
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
	
	//쿼리 결과가 없을 경우
	if($total == 0) {
	?>
          <tr>
            <td colspan="8"><p>발행 목록이 없습니다.</p></td>
          </tr>
          <?php
	}else {
        
	$sql_2 = "SELECT * FROM supplier, sp_tax_list WHERE supplier.id = sp_tax_list.id AND sp_tax_list.cancel='N'
			       ORDER BY sp_tax_list.num DESC LIMIT $cline,$scale1";
			  	 
    $result_2 = mysqli_query($connect, $sql_2);
 	
	for($i=1; $list = mysqli_fetch_array($result_2); $i++){
      
	   $bunho = $total - ( $i + $cline) + 1;
	   
      if($i%2 == 0)
	      echo "<tr class=odd>\n";
		  
 ?>
        <td><?=$bunho?></td>
        <td><?=$list['title']?></td>        
          <td><?=$list['reg_date']?></td>
          <td><?=$list['company_name']?></td>
          <td class="left"><?=$list['goods_name']?></td>
          <td><?=number_format($list['sum'])?>
            원 (VAT 포함)</td>
          <td><?php
		  	switch($list['approved']) {
				case "Y" : 
					echo "<img src=\"../images/printer_go.png\" />&nbsp;<a href=\"javascript:open_win('print_tax.php?num=$list[num]&id=$list[id]','nwin','scrollbars=yes,resizable=yes');\">출 력</a>";
					break;
				case "N" :
					echo "<img src=\"../images/pause_blue.png\" /> 미승인";
					break;
				case "C" :
					echo "<img src=\"../images/rewind_blue.png\" /><font color=\"#990000\"><strong> 반 려</strong></font>";
					break;
			}
			?>
          </td>
          <td><a href="../stats/delete_tax.php?num=<?=$list['num']?>"><img src="../images/delete.gif" /></a></td>
        </tr>
        <?php
		
		$tot_amount = $tot_amount + (int)$list['sum'];
	}
    mysqli_free_result($result_2);
  ?>
        <tr>
          <td colspan="5"><strong>발행금액 합계:</strong></td>
          <td><strong><?=number_format($tot_amount)?>
            원 (VAT 포함)</strong></td>
          <td colspan="2"></td>
        </tr>
        </tbody>
        
      </table>
      <table summary="page nav">
        <tbody>
          <tr>
            <td height="40" align="center" class="text"><?php
	 $url = "reg_stat_list.php?$id=$id&mode=$mode&company_name=$company_name"; 
 	 page_avg($totalpage,$cpage,$url); 
   ?>
              &nbsp; </td>
          </tr>
          <?php
	 }
	 ?>
        </tbody>
      </table>
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
