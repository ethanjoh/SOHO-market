<?php
$file_name = "preoffer_" . date("Y-m-d");

header("Content-type: application/vnd.ms-excel; charset=UTF-8");
header("Content-Disposition: attachment; filename=$file_name.xls");
header("Content-Description: PHP4 Generated Data");

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);
$oid     = set_var($_GET['oid']);

$today = date("Y-m-d");

//발주자 정보
$query  = "SELECT * FROM admin_setup WHERE type='1'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

$address = $row['addr1'] . " " . $row['addr2'];

?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
<head>
<title>발주서 </title>
<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
</head>
<body>
<table width="600" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td><table width="600" border="1" cellpadding="0" cellspacing="0" bordercolor="#3399FF">
        <tr>
          <td colspan="6"><div align="center"><h1>발 주 서</h1></div></td>
        </tr>
        <tr>
          <td colspan="2"><table width="100%" height="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td height="34" align="center" colspan="2"><u>발주일 : <?php echo date("Y/m/d"); ?> </u></td>
              </tr>
              <tr>
                <td height="30" colspan="2" align="center"><u>
                  <?php
//주문정보
$or_qry = "SELECT * FROM offer WHERE num = '$oid' ";
$or_res = mysqli_query($connect, $or_qry);
$or_row = mysqli_fetch_array($or_res);

$a_goods_fk = explode(",", $or_row['goods_fk']);
$mod_price  = explode(",", $or_row['mod_price']); //변경된 공급가
$org_volume = explode(",", $or_row['goods_count']);
$mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
$option     = explode(",", $or_row['goods_kind']); //옵션

$sp_qry = "SELECT * FROM supplier WHERE id='$or_row[id]'";
$sp_res = mysqli_query($connect, $sp_qry);
$sp_row = mysqli_fetch_array($sp_res);

$address2 = $sp_row['o_addr1'] . " " . $sp_row['o_addr2'];

echo $sp_row['company_name'] . "&nbsp;&nbsp;&nbsp;귀 하</u></font></td>";

?>
              </tr>
              <tr>
                <td align="center" colspan="2"><p>
                    <?=$sp_row['o_addr1'];?>
                    <?=$sp_row['o_addr2'];?>
                    <br />
                    TEL :
                    <?=$sp_row['o_phone'];?>
                    / FAX :
                    <?=$sp_row['o_fax'];?>
                  </p></td>
              </tr>
            </table></td>
          <td colspan="4"><table width="100%" height="100%" border="1" align="center" cellpadding="0" cellspacing="0" bordercolor="#3399FF">
              <tr>
                <td height="24" colspan="5"><div align="center"><font size="2">발 주 처</font></div></td>
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
                <td colspan="2"><?=$row['ceo'];?>
                  (인)</td>
              </tr>
              <tr>
                <td>사 업 장<br>
                  주 소 </td>
                <td colspan="4"><?=$address;?>
                  <br />
                  TEL :
                  <?=$row['tel'];?>
                  / FAX :
                  <?=$row['fax'];?></td>
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
          <td><div align="center">상 품 명</div></td>
          <td><div align="center">옵 션</div></td>
          <td><div align="center">발 주</div></td>
          <td><div align="center">소비자가</div></td>
          <td><div align="center">입고가</div></td>
          <td><div align="center">발주액</div></td>
        </tr>
        <?php
//주문상품 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);

    //$goods_name = show_icon($pro_row)."[".$pro_row['company']."] ".$pro_row['name'];

    echo "<tr>
					     <td class=\"name\">" . stripslashes($pro_row['name']) . "</td>\n
					     <td>" . $option[$i] . "</td>\n
					     <td class=\"num\">" . $org_volume[$i] . "</td>\n
					     <td class=\"won\">" . number_format($pro_row['retail_price']) . "</td>\n
					     <td class=\"won\">" . number_format($mod_price[$i]) . "</td>\n
					     <td class=\"won\">" . number_format($mod_price[$i] * $mod_volume[$i]) . "</td>\n
				    </tr>\n";

    $totalSum = $totalSum + (int) $mod_price[$i] * (int) $mod_volume[$i];
    $t_count  = $t_count + (int) $org_volume[$i];
    $mt_count = $mt_count + (int) $mod_volume[$i];

}

echo "<tr>\n
          <td class=\"left\"><strong>▶ TOTAL (VAT포함)</strong></td>
		      <td>&nbsp;</td>
          <td align=center><font color='blue'>$t_count</font>개</td>
          <td>&nbsp;</td>
          <td>&nbsp;</td>
          <td class=\"won\"><strong>" . number_format($totalSum) . "</strong></td>
		    </tr>\n";

?>
      </table></td>
  </tr>
</table>
<p>&nbsp;&nbsp;</p>
<table border="1">
  <tr>
    <td colspan="7" align="center"><font size="12px"><strong>메모</strong></font></td>
  </tr>
  <tr>
    <td colspan="7"><font size="12px"><?=nl2br($or_row['offer_memo']);?></font></td>
  </tr>
</table>
</body>
</html>