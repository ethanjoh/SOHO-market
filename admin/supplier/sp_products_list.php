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
<script type="text/javascript" src="../../js/global.js" ></script>
<script type="text/javascript" src="../js/admin.js" ></script>
<script type="text/javascript" src="../js/chrome.js" >
/***********************************************
* Chrome CSS Drop Down Menu- (c) Dynamic Drive DHTML code library (www.dynamicdrive.com)
* This notice MUST stay intact for legal use
* Visit Dynamic Drive at http://www.dynamicdrive.com/ for full source code
***********************************************/
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
          <li style="text-align:left">상품을 등록할 카테고리를 먼저 선택하세요.</li>
          <li style="text-align:left">유사상품을 반복해서 등록할 때는 [복사] 기능을 이용하세요.</li>
          <li style="text-align:left">본 페이지에서는 공급업체가 등록한 상품만 출력됩니다. </li>
          <li style="text-align:left">신상품/기획상품/인기상품은 메인화면에 표시 여부입니다.</li>
          <li style="text-align:left"><i class="fa fa-lock"></i> 표시는 숨김상품입니다. </li>
          <li style="text-align:left">업체등록 상품 확인 후 승인처리하시기 바랍니다.</li>
        </ul>
      </fieldset>

      <table summary="view category list">
        <caption>
        카테고리 리스트
        </caption>
        <tr class="odd">
          <td>
          <form name="category">
            <select name="lcode" onchange="sp_show_msub();">
              <option>--- 브랜드 ---</option>
              <?php
			$query = "SELECT * FROM products_category1 ORDER BY name ";
			$result2 = mysqli_query($connect, $query);	
			// 현재위치 표시
			for($i=1; $row2 = mysqli_fetch_array($result2); $i++){
				if($lcode == $row2['code']) 
					$sel = "selected=\"selected\"";
				else
					$sel = "";
				echo "<option value=\"$row2[code]\" $sel>$row2[name]</option>\n";
			}
			mysqli_free_result($result2);
			?>
            </select>
            </td>
            <td><select name="mcode" onchange="sp_show_ssub('<?=$lcode?>');">
                <option>--- 중분류 ---</option>
                <?php
				if($lcode) {
					$query = "SELECT * FROM products_category2 WHERE up_category='$lcode' ORDER BY code";
    				$result = mysqli_query($connect, $query);

					for($i=0; $row = mysqli_fetch_array($result); $i++){
							if($mcode == $row['code']) 
								$sel2 = "selected=\"selected\"";
							else
								$sel2 = "";
						echo "<option value=\"$row[code]\" $sel2>$row[name]</option>\n";
				   }
				}
			?>
              </select></td>
            <td><select name="scode" onchange="sp_show_last('<?=$lcode?>', '<?=$mcode?>');">
                <option>--- 소분류 ---</option>
                <?php
				if($mcode) {
					$query3 = "SELECT * FROM products_category3 WHERE up_category='$mcode' ORDER BY code";
    				$result3 = mysqli_query($connect, $query3);

					for($i=0; $srow = mysqli_fetch_array($result3); $i++){
							if($scode == $srow['code']) 
								$sel3 = "selected=\"selected\"";
							else
								$sel3 = "";
						echo "<option value=\"$srow[code]\" $sel3>$srow[name]</option>\n";
				   }
				}
			?>
              </select></td>
          </form>
        </tr>
      </table>
      <table summary="view product list">
        <caption>
        공급업체 상품 리스트
        </caption>
        <thead>
          <tr class="odd">
            <th scope="col" class="member">번호</th>
            <th scope="col" class="member" colspan="2" width="35%">제품명</th>
            <th scope="col" class="member">소비자가</th>
            <th scope="col" class="member">할인</th>
            <th scope="col" class="member">신상품</th>
            <th scope="col" class="member">기획상품</th>
            <th scope="col" class="member">인기상품</th>
            <th scope="col" class="member">승인</th>
            <th scope="col" class="member">복사</th>
          </tr>
        </thead>
        <tbody>
          <?php

			if($mode =='search'){
 				$search_keyword = " AND $key LIKE '%$keyword%' ";
				}

				if($lcode){
  					$qry_char = " AND category_l ='$lcode' ";
				}
				
				if($mcode){
  					$qry_char .= " AND category_m ='$mcode' ";
				}
				
				if($scode){
  					$qry_char .= " AND category_s ='$scode' ";
				}		

			// 상품의 정보를 모두 가져옴
			$query  = "SELECT * FROM products WHERE id<>'admin' $qry_char $search_keyword ";
			$result = mysqli_query($connect, $query);
			
			if($result) {
				$total  = mysqli_num_rows($result);
				mysqli_free_result($result);
			}
			   $scale=15;
			
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
			
			
			  $query = "SELECT * FROM products WHERE id<> 'admin' $qry_char $search_keyword ORDER BY num DESC LIMIT $cline,$scale1";
			  $result = mysqli_query($connect, $query);
			  
			  if($result) {
			
			  for($i=0; $prow = mysqli_fetch_array($result); $i++){
				$mqry = "SELECT * FROM supplier WHERE id='$prow[id]' ";
				$mres = mysqli_query($connect, $mqry);
				if($mres) { 
				   $mrow = mysqli_fetch_array($mres);
				   mysqli_free_result($mres);
				}
				   
					$list_num = $total - ($cline + $i);
				  
					if($i%2 == 1)
							echo "<tr class=\"odd\">\n";

?>
        <td><?=$list_num?></td>
        <td><img src="<?=$prow['s_image_name']?>" width="30" height="30" alt="small image" /></td>
          <td class="left"><?=show_icon($prow)?><a href="sp_pro_view.php?p_num=<?=$prow['num']?>&amp;lcode=<?=$prow['category_l']?>&amp;mcode=<?=$prow['category_m']?>&amp;scode=<?=$prow['category_s']?>&amp;page=<?=$page?>">
            <?=$prow['name']?>
            </a></td>
          <td><?=number_format(trim($prow['retail_price']))?>
            원</td>
          <td><?php 
				if($prow['sale_price'] > 0) {
			?>
            할인 중
            <?php
			}else {
			?>
            N/A
            <?php
			}
			?></td>
          <td><? if($prow['main_new']=='Y'){
			    echo "<img src='../images/forbbiden.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=del&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_new&page=$page'>취소</a>";
			   }
               else{
			    echo "<img src='../images/enabled.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=insert&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_new&page=$page'>등록</a>";
			   }
		  ?></td>
          <td><? if($prow['main_special']=='Y'){
			    echo "<img src='../images/forbbiden.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=del&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_special&page=$page'>취소</a>";
			   }
               else{
			    echo "<img src='../images/enabled.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=insert&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_special&page=$page'>등록</a>";
			   }
		  ?></td>
          <td><?php if($prow['main_best']=='Y'){
			    echo "<img src='../images/forbbiden.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=del&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_best&page=$page'>취소</a>";
			   }
               else{
			    echo "<img src='../images/enabled.gif' />&nbsp;<a href='pro_opt.php?p_num=$prow[num]&mode=insert&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&ck=main_best&page=$page'>등록</a>";
			   }
		  ?></td>
          <td><? if($prow['approved']=='N'){
			    echo "<img src='../images/forbbiden.gif' />&nbsp;미승인(<a href='pro_opt.php?p_num=$prow[num]&mode=approve&p_num=$prow[num]&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&page=$page'>승인처리</a>)";
			   }
               else{
			    echo "<img src='../images/enabled.gif' />&nbsp;완료(<a href='pro_opt.php?&mode=nonapprove&p_num=$prow[num]&lcode=$prow[category_l]&mcode=$prow[category_m]&scode=$prow[category_s]&page=$page'>취소</a>)";
			   }
		  ?></td>
          <form name="form1" action="sp_pro_register_ok.php" method="post" onsubmit="javascript:return confirm('상품을 복사하시겠습니까?');">
            <input type="hidden" name="mode" value="copy" />
            <input type="hidden" name="p_num" value="<?=$prow['num']?>" />
            <td><input type="image" src="../images/database_copy.png" style="border-color:#FFFFFF;background-color:#FFFFFF;vertical-align:middle" /></td>
          </form>
        </tr>
        <?php
}
mysqli_free_result($result);

			  }//if($result)
?>
        <?php
if($total == 0){
?>
        <tr>
          <td colspan="11"><p>등록된 상품이 없습니다.</p></td>
        </tr>
        <?php
	}
?>
        </tbody>
        
      </table>
      <form action='sp_products_list.php' name='f' method='post' >
        <tr bgcolor="#FFFFFF" align="center">
          <td colspan="10">해당 카테고리 내 검색 :
            <select name='key'>
              <option value='name'>상품명</option>
              <option value='company'>제조사</option>
            </select>
            <input type='hidden' name='mode' value='search' />
            <input type='hidden' name='lcode' value='<?=$lcode?>' />
            <input type='hidden' name='mcode' value='<?=$mcode?>' />
            <input type='hidden' name='scode' value='<?=$scode?>' />
            <input type='text' name='keyword' size='16' />
            <input type="image" src="../images/search_btn.gif" style="background-color:#FFFFFF; border:none;vertical-align: middle; " /></td>
        </tr>
      </form>
      </table>
      </td>
      </tr>
      </table>
      <table summary="page">
        <tbody>
          <tr>
            <td><?php
	  $url = "$PHP_SELF?mode=$mode&lcode=$lcode&mcode=$mcode&scode=$scode&key=$key&keyword=$keyword"; 
      page_avg($totalpage,$cpage,$url); 
	?></td>
          </tr>
        </tbody>
      </table>
      <div class="clear"><a class="button" href="sp_pro_register.php?lcode=<?=$lcode?>&amp;mcode=<?=$mcode?>&amp;scode=<?=$scode?>&amp;page=<?=$page?>" onclick="this.blur();"><span>상품등록</span></a><a class="button" href="#" onClick="this.blur(); location='sp_products_list.php?lcode=<?=$lcode?>&mcode=<?=$mcode?>&scode=<?=$scode?>&page=<?=$page?>'"><span>다시 읽기</span></a></div>
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
