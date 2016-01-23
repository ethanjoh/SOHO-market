<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);
$oid = set_var($_GET['oid']);
$today = date("Y-m-d");
//발주자 정보
$query = "SELECT * FROM admin_setup WHERE type='1'";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
$address = $row['addr1']." ".$row['addr2'];
?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
  <head>
    <title>B2B SCM</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" media="print" href="../css/print.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />
  </head>
  <body onLoad="window.focus();window.print();">
    <!-- wrapper -->
    <div id="wrapper">
      <div id="bodyblock">
        <!-- contents -->
        <div id="content">
          <table>
            <tr>
              <td colspan="8"><h1>발 주 서</h1></td>
            </tr>
            <tr>
              <td colspan="2">
                <table>
                  <tr>
                    <td height="34" ><u>발주일 : <? echo date("Y/m/d"); ?> </u></td>
                  </tr>
                  <tr>
                    <td height="30"><u>
                      <?php
                      //주문정보
                      $or_qry = "SELECT * FROM offer WHERE num = '$oid' ";
                      $or_res = mysqli_query($connect, $or_qry);
                      $or_row = mysqli_fetch_array($or_res);
                      
                      $a_goods_fk = explode(",", $or_row['goods_fk']);
                      $mod_price = explode(",", $or_row['mod_price']); //변경된 공급가
                      $org_volume = explode(",", $or_row['goods_count']);
                      $mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
                      $option = explode(",", $or_row['goods_kind']); //옵션
                      
                      $sp_qry = "SELECT * FROM supplier WHERE id='$or_row[id]'";
                      $sp_res = mysqli_query($connect, $sp_qry);
                      $sp_row = mysqli_fetch_array($sp_res);
                      
                      $address2 = $sp_row['o_addr1']." ".$sp_row['o_addr2'];
                      
                    echo $sp_row['company_name']."&nbsp;&nbsp;&nbsp;귀 하</u></font></td>";
                    
                    ?>
                  </tr>
                  <tr>
                    <td><p><?=$sp_row['o_addr1']?><?=$sp_row['o_addr2']?><br />TEL : <?=$sp_row['o_phone']?> / FAX : <?=$sp_row['o_fax']?></p></td>
                  </tr>
                </table></td>
                <td colspan="6"><table width="100%" height="100%">
                  <tr>
                    <td height="24" colspan="5">발&nbsp;&nbsp;주&nbsp;&nbsp;처</font></td>
                  </tr>
                  <tr>
                    <td width="66">등 록<br />번 호</td>
                    <td colspan="4"><div align="center"><strong><?=$row['license_no']?></strong></td>
                  </tr>
                  <tr>
                    <td>상 호</td>
                    <td width="100"><?=$row['company_name']?></td>
                    <td>성 명</td>
                    <td colspan="2"><?=$row['ceo']?> (인)</td>
                  </tr>
                  <tr>
                    <td>사 업 장<br />주 소 </td>
                    <td colspan="4"><?=$address?><br />TEL : <?=$row['tel']?> / FAX : <?=$row['fax']?></td>
                  </tr>
                  <tr>
                    <td>업 태</td>
                    <td><?=$row['category1']?></td>
                    <td>종 목</td>
                    <td colspan="2"><?=$row['category2']?></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td>상 품 명</td>
                <td>옵 션</td>
                <td>발 주</td>
                <td>소비자가</td>
                <td>입고가</td>
                <td>발주액</td>
              </tr>
              <?php
              //주문상품 정보를 불러옵니다.
              for($i=0; $i<sizeof($a_goods_fk); $i++) {
                $pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
                $pro_result = mysqli_query($connect, $pro_sql);
                $pro_row = mysqli_fetch_array($pro_result);
              
                //$goods_name = show_icon($pro_row)."[".$pro_row['company']."] ".$pro_row['name'];
                echo "<tr>\n";
                echo "  <td class=\"name\">".stripslashes($pro_row['name'])."</td>\n";
                echo "  <td>".$option[$i]."</td>\n";
                echo "  <td class=\"num\">".$org_volume[$i]."</td>\n";
                echo "  <td class=\"won\">".number_format($pro_row['retail_price'])."</td>\n";
                echo "  <td class=\"won\">".number_format($mod_price[$i])."</td>\n";
                echo "  <td class=\"won\">".number_format($mod_price[$i]*$mod_volume[$i])."</td>\n";
                echo "</tr>\n";
                
                $totalSum = $totalSum+(int)$mod_price[$i]*(int)$mod_volume[$i];
                $t_count = $t_count + (int)$org_volume[$i];
                $mt_count = $mt_count + (int)$mod_volume[$i];
              
              }
                echo "<tr>\n";
                echo "  <td class=\"left\"><strong>▶ TOTAL (VAT포함)</strong></td>\n";
                echo "  <td>&nbsp;</td>\n";
                echo "  <td align=center><font color='blue'>$t_count</font>개</td>\n";
                echo "  <td>&nbsp;</td>\n";
                echo "  <td>&nbsp;</td>\n";
                echo "  <td class=\"won\"><strong>".number_format($totalSum)."</strong></td>\n";
                echo "</tr>\n";
              ?>
            </table>
        <br />
        <table border="1">
          <tr>
            <td colspan="7" align="center" class="fnt12"><strong>메모</strong></td>
          </tr>
          <tr>
            <td colspan="7" class="fnt12 left"><p><?=nl2br($or_row['offer_memo'])?></p></td>
          </tr>
        </table>
        <br />
        <div id="print">
          <input type="submit" value="인쇄하기" onClick="javascript:window.print();">
          <input type="submit" name="Submit3" value="닫 기" onClick="JavaScript:window.close();">
        </div>
      </div>
      <!-- contens end -->
    </div>
    <!-- bodyblock end -->
  </div>
  <!-- wrapper end -->
</body>
</html>