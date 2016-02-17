<?php
include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
$oid     = set_var($_GET['oid']);
$today   = date("Y-m-d");

//공급자 정보
$query   = "SELECT * FROM admin_setup WHERE type='1'";
$result  = mysqli_query($connect, $query);
$row     = mysqli_fetch_array($result);
$address = $row['addr1'] . " " . $row['addr2'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
  <head>
    <title>B2B SCM</title>
    <meta http-equiv="content-type" content="text/html; charset=UTF-8" />
    <link rel="stylesheet" type="text/css" media="print" href="../css/print.css" />
    <link rel="stylesheet" type="text/css" media="screen" href="../css/screen.css" />
  </head>
  <body onLoad="window.print()">
    <!-- wrapper -->
    <div id="wrapper">
      <div id="bodyblock">
        <!-- contents -->
        <div id="content">
          <table>
            <tr>
              <td colspan="8"><h1>거 래 명 세 서</h1></td>
            </tr>
            <tr>
              <td colspan="2"><table>
                <?php
//주문정보
$or_qry = "SELECT * FROM mall_order WHERE num = '$oid' ";
$or_res = mysqli_query($connect, $or_qry);
$or_row = mysqli_fetch_array($or_res);
?>
                <tr>
                  <td height="34" ><u>
                    <?=$or_row['createdate'];?>
                  </u></td>
                </tr>
                <tr>
                  <td height="30"><u>
                    <?php
$a_goods_fk = explode(",", $or_row['goods_fk']);
$mod_price  = explode(",", $or_row['mod_price']); //변경된 공급가
$org_volume = explode(",", $or_row['goods_count']);
$mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
$option     = explode(",", $or_row['goods_kind']); //옵션

$buyer_qry = "SELECT * FROM member WHERE id='$or_row[user_id]'";
$buyer_res = mysqli_query($connect, $buyer_qry);
$buyer_row = mysqli_fetch_array($buyer_res);

$address2 = $buyer_row['o_addr1'] . " " . $buyer_row['o_addr2'];

if ($or_row['recipient_name']) {
    echo $buyer_row['company_name'] . "&nbsp;-> " . $or_row['recipient_name'] . "&nbsp;&nbsp;귀 하</u></font></td>";
} else {
    echo $buyer_row['company_name'] . "&nbsp;&nbsp;&nbsp;귀 하</u></font></td>";
}

?>
              </tr>
              <tr>
                <td><p>
                  <u>아래와 같이 계산합니다.</u>
                </p></td>
              </tr>
            </table></td>
            <td colspan="6"><table width="100%" height="100%">
              <tr>
                <td height="24" colspan="5">공&nbsp;&nbsp;급&nbsp;&nbsp;자</font></td>
              </tr>
              <tr>
                <td width="66">등 록<br>
                번 호</td>
                <td colspan="4"><div align="center">
                  <strong>
                  <?=$row['license_no'];?>
                </strong></td>
              </tr>
              <tr>
                <td>상 호</td>
                <td width="100"><?=$row['company_name'];?></td>
                <td>성 명</td>
                <td colspan="2">
                  <div style="position: relative; background: url(../images/sign/stamp.gif) no-repeat; background-position: 20px 0px; height: 60px; width: auto;">
                    <div style="position: absolute; bottom: 25px; margin:auto;"><?=$row['ceo'];?> (인)</div>
                  </div>
                </td>
              </tr>
              <tr>
                <td>사 업 장<br>
                주 소 </td>
                <td colspan="4"><?=$address;?></td>
              </tr>
              <tr>
                <td>업 태</td>
                <td><?=$row['category1'];?></td>
                <td>종 목</td>
                <td colspan="2"><?=$row['category2'];?></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td>상 품 명</td>
            <td>옵 션</td>
            <td>주 문</td>
            <td>출 고</td>
            <td>소비자가</td>
            <td>단 가</td>
            <td>공급가액</td>
            <td>세 액</td>
          </tr>
          <?php
//주문상품 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    $goods_name = show_icon($pro_row) . "[" . $pro_row['company'] . "] " . $pro_row['name'];
    //상품옵션 품절표시
    //상품 옵션이 있는지 확인 후 진행
    if ($option[$i] != "") {
        //장바구니의 옵션과 제품정보를 비교하여 품절옵션이 있는지 확인
        $t_opt       = explode(",", $pro_row['opt']); //제품의 옵션명을 배열로 만들어준다
        $t_opt_stock = explode(",", $pro_row['opt_stock']); //제품의 옵션재고를 배열로 만들어준다

        //옵션의 문자열 비교
        for ($j = 0; $j < count($t_opt); $j++) {
            $str = strcmp($t_opt[$j], $option[$i]);

            if (!$str) {
                //문자열이 같다면 문자열 대체
                if ($t_opt_stock[$j] == "0") {
                    $option[$i] .= " (품절)";
                } elseif ($t_opt_stock[$j] == "-1") {
                    $option[$i] .= " (단종)";
                } else {
                    $option[$i] = $t_opt[$j];
                }

            }

        } //end of for loop
    } //end of if clause

    echo "<tr>
                      <td class=\"name\">" . stripslashes($goods_name) . "</td>\n
                      <td>" . $option[$i] . "</td>\n
                      <td class=\"num\">" . $org_volume[$i] . "</td>\n
                      <td class=\"num\">" . $mod_volume[$i] . "</td>\n";

    if ($pro_row['sale_price']) {
        echo "<td class=\"won\"><s>" . number_format($pro_row['retail_price']) . "</s><br/>" . number_format($pro_row['sale_price']) . "\n";
    } else {
        echo "<td class=\"won\">" . number_format($pro_row['retail_price']) . "\n";
    }
    echo "<td class=\"won\">" . number_format($mod_price[$i]) . "</td>\n
                          <td class=\"won\">" . number_format($mod_price[$i] * $mod_volume[$i]) . "</td>\n
                          <td class=\"won\">" . number_format(($mod_price[$i] * $mod_volume[$i]) * 0.1) . "</td>\n
                        </tr>\n";

    $totalSum = $totalSum + (int) $mod_price[$i] * (int) $mod_volume[$i];
    //$vatSum = $vatSum+(int)($mod_price[$i]*$mod_volume[$i])*0.1;
    $t_count  = $t_count + (int) $org_volume[$i];
    $mt_count = $mt_count + (int) $mod_volume[$i];

}
echo "<tr>\n";
echo "<td class=\"left\">▶ SUB TOTAL </td>\n
                    <td>&nbsp;</td>\n
                <td align=center><font color='blue'>$t_count</font>개</td>\n
                    <td align=center><font color='blue'>$mt_count</font>개</td>\n
                <td>&nbsp;</td>\n
                    <td>&nbsp;</td>\n
                <td class=\"won\"><strong>" . number_format($totalSum) . "</strong></td>\n
                <td class=\"won\"><strong>" . number_format($totalSum * 0.1) . "</strong></td>\n
                  </tr>\n";

$final = $totalSum + $last_cost2;

echo "<tr>\n";
echo "<td colspan=\"6\" class=\"left\"><strong>▶ TOTAL(inc.VAT) : </strong></td>\n
                  <td class=\"won\" colspan=\"2\"><strong>" . number_format($final * 1.1) . "</strong></td>\n
                    </tr>\n";
echo "<tr>\n
                      <td colspan=\"8\">TEL :" . $row['tel'] . ", FAX :  " . $row['fax'] . " (주문마감시간 평일 오후 2시, 토/일 휴무)
                      </td>\n
                    </tr> \n";
?>
              </table></td>
            </tr>
          </table>
          <br/>

        <div id="print">
          <table align="center">
            <tr>
              <td><input type="submit" value="인쇄하기" onClick="javascript:window.print();" />
              <input type="submit" name="Submit3" value="닫 기" onClick="JavaScript:window.close();" /></td>
            </tr>
          </table>
        </div>

      </div>
      <!-- contens end -->
    </div>
    <!-- bodyblock end -->
  </div>
  <!-- wrapper end -->
</body>
</html>