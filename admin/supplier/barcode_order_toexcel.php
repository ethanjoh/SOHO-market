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
$today   = date("Y-m-d");
//발주자 정보
$query  = "SELECT * FROM admin_setup WHERE type='1'";
$result = mysqli_query($connect, $query);
$row    = mysqli_fetch_array($result);

//주문정보
$or_qry = "SELECT * FROM offer WHERE num = '$oid' ";
$or_res = mysqli_query($connect, $or_qry);
$or_row = mysqli_fetch_array($or_res);

$a_goods_fk = explode(",", $or_row['goods_fk']);
$mod_price  = explode(",", $or_row['mod_price']); //변경된 공급가
$org_volume = explode(",", $or_row['goods_count']);
$mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
$option     = explode(",", $or_row['goods_kind']); //옵션
$barcode    = explode(",", $or_row['goods_barcode']);

$sp_qry = "SELECT * FROM supplier WHERE id='$or_row[id]'";
$sp_res = mysqli_query($connect, $sp_qry);
$sp_row = mysqli_fetch_array($sp_res);

$address2 = $sp_row['o_addr1'] . " " . $sp_row['o_addr2'];

?>
<!DOCTYPE html>
<html lang="ko">
	<head>
		<title><?=$sp_row['company_name'];?> 발주서</title>
		<meta charset="UTF-8" />
		<style type="text/css">
		body {
			font-family: "돋움", "새굴림", verdana, helvetica;
			font-size: 9px;
		}
		</style>
	</head>
	<body onLoad="window.focus();window.print();">
		<?php

;?>
		<div align="center">
			<!-- header -->
			<table width="600" border="0" cellpadding="0" cellspacing="0" bordercolor="#C4C4C4">
				<tbody>
					<tr>
						<td colspan="4"><font size="18">발주서</font> </td>
						<td width="13%">&nbsp;</td>
						<td>&nbsp;</td>
						<td width="7%">&nbsp;</td>
						<td width="10%">&nbsp;</td>
						<td>발주일</td>
						<td colspan="2"><?=$today;?></td>
					</tr>
					<tr>
						<td colspan="12">
					</tr>
					<!-- 공급처 -->
					<tr>
						<td  bgcolor="#C4C4C4" colspan="5">공급처</td>
						<td width="9%">&nbsp;</td>
						<td  bgcolor="#C4C4C4" colspan="6">발주처</td>
					</tr>
					<tr>
						<td width="4%" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">상호</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$sp_row['company_name'];?></td>
						<td width="4%" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">대표자</td>
						<td style="border-bottom:1px solid #C4C4C4;"><?=$sp_row['ceo'];?> (인)</td>
						<td>&nbsp;</td>
						<td colspan="2" width="4%" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">상호</td>
						<td width="12%" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$row['company_name'];?></td>
						<td width="8%" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">대표자</td>
						<td colspan="2" width="17%" style="border-bottom:1px solid #C4C4C4;"><?=$row['ceo'];?> (인)</td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">등록번호</td>
						<td colspan="4" style="border-bottom:1px solid #C4C4C4;"><?=$sp_row['license_no'];?></td>
						<td>&nbsp;</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">등록번호</td>
						<td colspan="4" style="border-bottom:1px solid #C4C4C4;"><?=$row['license_no'];?></td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">주소</td>
						<td colspan="4" style="border-bottom:1px solid #C4C4C4;"><?=$sp_row['o_addr1'];?><br /><?=$sp_row['o_addr2'];?></td>
						<td>&nbsp;</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">주소</td>
						<td colspan="4" style="border-bottom:1px solid #C4C4C4;"><?=$row['addr1'];?><br /><?=$row['addr2'];?></td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">전화</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$sp_row['o_phone'];?></td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">팩스</td>
						<td style="border-bottom:1px solid #C4C4C4;"><?=$sp_row['o_fax'];?></td>
						<td>&nbsp;</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">전화</td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$row['tel'];?></td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">팩스</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;"><?=$row['fax'];?></td>
					</tr>
					<tr>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">담당자</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$sp_row['md_name'];?></td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">연락처</td>
						<td style="border-bottom:1px solid #C4C4C4;"><?=$sp_row['tel'];?></td>
						<td>&nbsp;</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">담당자</td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$row['name'];?></td>
						<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;">연락처</td>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;"><?=$row['tel'];?></td>
					</tr>
				<tr>
					<td height="10px" colspan="12"><br /></td>
				</tr>
				<tr>
					<td colspan="4" bgcolor="#e5e0e0" style="font-weight:bold;font-size:18px;">합계금액(공급가액 + 세액)</td>p
					<td bgcolor="#e5e0e0">&nbsp;</td>
					<td bgcolor="#e5e0e0">&nbsp;</td>
					<td bgcolor="#e5e0e0">&nbsp;</td>
					<td bgcolor="#e5e0e0">&nbsp;</td>
					<td colspan="4" bgcolor="#e5e0e0"><p style="text-align:right;font-weight:bold;font-size:18px;"><?=number_format($or_row['amount']);?> 원</p></td>
				</tr>
				<tr>
					<td colspan="12"><br /></td>
				</tr>
				<tr>
					<td colspan="2" bgcolor="#C4C4C4"><p align="center">바코드</p></td>
					<td colspan="3" bgcolor="#C4C4C4"><p align="center">품명</p></td>
					<td bgcolor="#C4C4C4"><p align="center">옵션</p></td>
					<td colspan="2" bgcolor="#C4C4C4"><p align="center">수량</p></td>
					<td bgcolor="#C4C4C4"><p align="center">단가</p></td>
					<td colspan="2" bgcolor="#C4C4C4"><p align="center">금액</p></td>
					<td bgcolor="#C4C4C4"><p align="center">비고</p></td>
				</tr>
				<?php
//주문상품 정보를 불러옵니다.
for ($i = 0; $i < sizeof($a_goods_fk); $i++) {
    $pro_sql    = "SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
    $pro_result = mysqli_query($connect, $pro_sql);
    $pro_row    = mysqli_fetch_array($pro_result);
    ?>

				<tr>
					<div>
						<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;mso-number-format:\@;"><?=$barcode[$i];?></td>
					</div>
					<td colspan="3" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=stripslashes($pro_row['name']);?></td>
					<td style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=$option[$i];?></td>
					<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><p align="right"><?=$org_volume[$i];?></p></td>
					<td><p align="right" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><?=number_format($mod_price[$i]);?></p></td>
					<td colspan="2" style="border-bottom:1px solid #C4C4C4;border-right:1px solid #C4C4C4;"><p align="right"><?=number_format($mod_price[$i] * $mod_volume[$i]);?></p></td>
					<td style="border-bottom:1px solid #C4C4C4;">&nbsp;</td>
				</tr>

				<?php

    $totalSum = $totalSum + (int) $mod_price[$i] * (int) $mod_volume[$i];
    $t_count  = $t_count + (int) $org_volume[$i];
    $mt_count = $mt_count + (int) $mod_volume[$i];
}
?>
				<tr>
					<td colspan="6" bgcolor="#e5e0e0" style="border-right:1px solid #C4C4C4;font-size:18px;">합계</td>
					<td colspan="2" bgcolor="#e5e0e0" style="border-right:1px solid #C4C4C4;"><p align="right"><?=$t_count;?></p></td>
					<td bgcolor="#e5e0e0" style="border-right:1px solid #C4C4C4;">&nbsp;</td>
					<td colspan="2" bgcolor="#e5e0e0" style="border-right:1px solid #C4C4C4;"><p style="text-align:right;font-weight:bold;font-size:18px;"><?=number_format($totalSum);?></p></td>
					<td bgcolor="#e5e0e0">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="12">&nbsp;</td>
				</tr>
				<tr>
					<td colspan="12" bgcolor="#e5e0e0">기타</td>
				</tr>
				<tr>
					<td colspan="12"><p><?=nl2br($or_row['offer_memo']);?></p></td>
				</tr>
			</table>
		</div>
		<br />
	</body>
</html>