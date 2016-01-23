<?php

if($mode == 'search'){
  if($id){
    $search_keyword .= " and id = '$id' ";
  }

  if($company_name){
    $search_keyword .= " and company_name like '%$company_name%' ";
  }
    
}else if($mode == 'nonapproved') {
	$search_keyword .= " and approved='N' ";
}

//회원 테이블의 리스트를 불러옵니다.
$query = "SELECT * FROM member WHERE 1 $search_keyword "; 
$result = mysqli_query($connect, $query);
$total = mysqli_num_rows($result);

?>
      <form name="mb" method="post" action="top_member_list.php">
        <input type="hidden" name="mode" value="search" />
        <fieldset>
        <legend>공급업체 찾기</legend>
        <p>
          <label for="id">아이디:</label>
          <input type="text" name="id" value='<?=$id?>' size="20">
          <label for="company_name">업체명:</label>
          <input type="text" name="company_name" value='<?=$company_name?>' size="20" >
        </p>
        <div class="clear"><a class="button" href="../document.mb.submit()" onclick="this.blur();"><span>찾기</span></a></div>
        </fieldset>
      </form>
      <table summary="functions">
        <tbody>
          <tr>
            <td><div class="full"><a class="button" href="top_member_list.php?mode=nonapproved" onclick="this.blur();"><span>미승인 업체</span></a><a class="button" href="top_member_list.php" onclick="this.blur();"><span>전체 목록</span></a></div></td>
          </tr>
        </tbody>
      </table>      
      <table summary="member list">
        <caption>
        총 가입업체 리스트 (
        <?=number_format($total)?>
        개 )
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col" class="member">번호</th>
            <th scope="col" class="member">아이디</th>
            <th scope="col" class="member">업체명</th>
            <th scope="col" class="member">사업자등록번호</th>
            <th scope="col" class="member">사무실 전화번호</th>
            <th scope="col" class="member">담당자</th>
            <th scope="col" class="member">휴대폰</th>
            <th scope="col" class="member">가입일자</th>
            <th scope="col" class="member">삭제</th>
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
				    
	$sql_2 = "select * from member where 1 $search_keyword order by seq_num desc LIMIT $cline,$scale1 "; 
    $result_2 = mysqli_query($connect, $sql_2);
 	for($i=1; $list = mysqli_fetch_array($result_2); $i++){
      
	   $bunho = $total - ( $i + $cline) + 1; 
	   
      if($i%2 == 0)
	      echo "<tr class=odd>\n";
	  else
	      echo "<tr>\n";
 ?>
        <th scope="row" class="column1"><?=$bunho?></th>
          <td ><a href="javascript:open_win('mem_view_member.php?num=<?=$list['seq_num']?>','nwin','scrollbars=yes,resizable=yes, width=650,height=650');">
            <?=$list['id']?>
            </a></td>
          <td><?=$list['company_name']?></td>
          <td><?=$list['license_no']?></td>
          <td><?=$list['o_phone']?></td>
          <td><?=$list['md_name']?></td>
          <td><?=$list['md_hphone']?></td>
          <td><?=$list['reg_date']?></td>
          <td><a href="mem_delete_member.php?m_num=<?=$list['seq_num']?>&amp;page=<?=$page?>" onclick="this.blur(); return confirm('삭제를 하시게 되면 이 회원의 모든 정보가 삭제됩니다. \n삭제하시겠습니까?')"><img src="../images/delete.gif" alt="삭제" /></a></td>
        </tr>
        <?php
    }
    mysqli_free_result($result_2);
  ?>
        </tbody>
      </table>
      <table summary="page nav">
        <tbody>
          <tr>
            <td height="40" align="center" class="text"><?php
	 $url = "top_member_list.php?$id=$id&mode=$mode&license_no=$license_no&md_email=$md_email&o_phone=$o_phone&company_name=$company_name&md_hphone=$md_hphone"; 
 	 page_avg($totalpage,$cpage,$url); 
   ?>
              &nbsp; </td>
          </tr>
        </tbody>
      </table>