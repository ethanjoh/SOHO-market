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

//주문정보
$or_qry = "SELECT * FROM offer WHERE num = '$oid' ";
$or_res = mysqli_query($connect, $or_qry);
$or_row = mysqli_fetch_array($or_res);

$a_goods_fk = explode(",", $or_row['goods_fk']);
$mod_price = explode(",", $or_row['mod_price']); //변경된 공급가
$org_volume = explode(",", $or_row['goods_count']);
$mod_volume = explode(",", $or_row['mod_count']); //변경된 수량
$option = explode(",", $or_row['goods_kind']); //옵션
$barcode = explode(",", $or_row['goods_barcode']); //옵션

$sp_qry = "SELECT * FROM supplier WHERE id='$or_row[id]'";
$sp_res = mysqli_query($connect, $sp_qry);
$sp_row = mysqli_fetch_array($sp_res);

$address2 = $sp_row['o_addr1']." ".$sp_row['o_addr2'];

?>

<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" lang="ko" xml:lang="ko">
	<head>
		<title><?=$sp_row['company_name']?> 발주서</title>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" />
		<link rel="stylesheet" type="text/css" media="print" href="../css/supplier_print.css">
		<link rel="stylesheet" type="text/css" media="screen" href="../css/supplier.css">
		<script src="//code.jquery.com/jquery-1.11.0.min.js"></script>
		<script>
			$(document).ready(function () {
				$("#sumNum").text($("#totalSum").text()+' 원');
			});
		</script>
	</head>
	<body onLoad="window.focus();window.print();">
		<div id="wrapper">
			<!-- header -->
			<table class="none">
				<tbody>
					<tr class="none">
						<td><span id="title">발주서</span><span id="orderDate">발주일 <?=$today?></span></td>
					</tr>
					<tr class="none">
						<td colspan="3">
							<!-- 공급처 -->
							<table class="flLeft fntSmall">
								<tr class="bgGray">
									<td colspan="4">공급처</td>
								</tr>
								<tr class="topBtmBorder">
									<td>상호</td>
									<td><?=$sp_row['company_name']?></td>
									<td>대표자</td>
									<td><?=$sp_row['ceo']?> (인)</td>
								</tr>
								<tr>
									<td>등록번호</td>
									<td colspan="3"><?=$sp_row['license_no']?></td>
								</tr>
								<tr>
									<td>주소</td>
									<td colspan="3"><?=$sp_row['o_addr1']?><br /><?=$sp_row['o_addr2']?></td>
								</tr>
								<tr>
									<td>전화</td>
									<td><?=$sp_row['o_phone']?></td>
									<td>팩스</td>
									<td><?=$sp_row['o_fax']?></td>
								</tr>
								<tr>
									<td>담당자</td>
									<td><?=$sp_row['md_name']?></td>
									<td>연락처</td>
									<td><?=$sp_row['md_hphone']?></td>
								</tr>
							</table>
							<!-- end 공급처 -->
							<!-- 발주처 -->
							<table class="flRight fntSmall">
								<tr class="bgGray">
									<td colspan="4">발주처</td>
								</tr>
								<tr>
									<td>상호</td>
									<td><?=$row['company_name']?></td>
									<td>대표자</td>
									<td><?=$row['ceo']?> (인)</td>
								</tr>
								<tr>
									<td>등록번호</td>
									<td colspan="3"><?=$row['license_no']?></td>
								</tr>
								<tr>
									<td>주소</td>
									<td colspan="3"><?=$row['addr1']?><br /><?=$row['addr2']?></td>
								</tr>
								<tr>
									<td>전화</td>
									<td><?=$row['tel']?></td>
									<td>팩스</td>
									<td><?=$row['fax']?></td>
								</tr>
								<tr>
									<td>담당자</td>
									<td><?=$row['name']?></td>
									<td>연락처</td>
									<td><?=$row['tel']?></td>
								</tr>
							</table>
							<!-- end 발주처 -->
						</td>
					</tr>
				</tbody>
			</table>
			<!-- 합계 -->
			<table class="topMargin30">
				<tr class="bgLightGray">
					<td><span class="sum">합계금액 <span class="fntSmall">(공급가액 + 세액)</span></span><div id="sumNum" class="sumNum"></div></td>
				</tr>
			</table>
			<!-- 명세내역 -->
			<table class="total fntMid">
				<tr class="bgGray txtCenter">
					<td>바코드</td>
					<td>품명</td>
					<td>옵션</td>
					<td>수량</td>
					<td>단가</td>
					<td>금액</td>
					<td>비고</td>
				</tr>
				<?php
              	//주문상품 정보를 불러옵니다.
              	for($i=0; $i<sizeof($a_goods_fk); $i++) {
              		$pro_sql="SELECT * FROM products WHERE num='$a_goods_fk[$i]'";
                	$pro_result = mysqli_query($connect, $pro_sql);
                	$pro_row = mysqli_fetch_array($pro_result);

                	echo "<tr>\n";
                	echo "	<td>".$barcode[$i]."</td>\n";
					echo "	<td>".stripslashes($pro_row['name'])."</td>\n";
					echo "	<td>".$option[$i]."</td>\n";
					echo "	<td class=\"num\">".$org_volume[$i]."</td>\n";
					echo "	<td class=\"num\">".number_format($mod_price[$i])."</td>\n";
					echo "	<td class=\"num\">".number_format($mod_price[$i]*$mod_volume[$i])."</td>\n";
					echo "	<td>&nbsp;</td>\n";
					echo "</tr>\n";

					$totalSum = $totalSum+(int)$mod_price[$i]*(int)$mod_volume[$i];
                	$t_count = $t_count + (int)$org_volume[$i];
                	$mt_count = $mt_count + (int)$mod_volume[$i];
                }
                ?>
				<tr class="bgLightGray">
					<td colspan="3">합계</td>
					<td class="num"><?=$t_count?></td>
					<td>&nbsp;</td>
					<td class="num"><div id="totalSum"><?=number_format($totalSum)?></div></td>
					<td>&nbsp;</td>
				</tr>
			</table>
			<table>
				<tr class="bgLightGray">
					<td>기타</td>
				</tr>
				<tr>
					<td><p><?=nl2br($or_row['offer_memo'])?></p></td>
				</tr>
			</table>
		</div>
        <br />
        <div id="print">
          <input type="submit" value="인쇄하기" onClick="javascript:window.print();">
          <input type="submit" name="Submit3" value="닫 기" onClick="JavaScript:window.close();">
        </div>
	</body>
</html>