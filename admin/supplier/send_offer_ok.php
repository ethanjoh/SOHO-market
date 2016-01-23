<?php
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect=my_connect($host,$dbid,$dbpass,$dbname);

$id = set_var($_POST['id']);
$num = set_var($_POST['chk']);
//$products_name = set_var($_POST['products_name']);
//$products_kind = set_var($_POST['products_kind']);
$products_count = set_var($_POST['count']);
$products_price = set_var($_POST['offer_price']);
$opt_name = set_var($_POST['opt_name']);
$opt_count = set_var($_POST['opt_count']);
$opt_price = set_var($_POST['opt_price']);

$memo = set_var($_POST['memo']); 

for($i=0; $i<sizeof($num); $i++) {
	if(isset($num[$i])) {
		$qry = "SELECT * FROM products WHERE num='$num[$i]' ";
		$res = mysqli_query($connect, $qry);
		$row = mysqli_fetch_array($res);

	if($i != 0){
       	$temp_code .= ",";
			$temp_name .= ",";
			$temp_count .= ",";
			$temp_price .= ",";
			$temp_amount  .= ",";
			$temp_kind .= ",";
    	}
	 $temp_code .= $num[$i];	

   if($opt_name) {
    $temp_name .= $row['name'];
     $temp_kind .= $opt_name[$i];
   	$temp_count .= $opt_count[$i];
	  $temp_price .= $opt_price[$i];
	  $temp_amount .= ($opt_count[$i]*$opt_price[$i]);
   }else {
      $temp_name .= $row['name'];
   	$temp_count .= $products_count[$i];
   	$temp_price .= $products_price[$i];
	  $temp_amount .= ($products_count[$i]*$products_price[$i]);	
   }
   
	}	
}

$query = "INSERT INTO p_code VALUES ('')";
mysqli_query($connect, $query);

$query = "SELECT max(id) AS maxid FROM p_code";
$result = mysqli_query($connect, $query);
$row = mysqli_fetch_array($result);
mysqli_free_result($result);
$p_code = $row['maxid'];

$today = date('Y-m-d');

//발주번호 작성
$wdate = date('Ymd');
$trade_code ="0".$wdate."-".$p_code;

$memo = addslashes($memo);

$query = "INSERT INTO offer(orderid,goods_fk,goods_price, mod_price,
            										goods_name,goods_kind,goods_count,mod_count, 
										            id,amount,volume, createdate, memo )
		 VALUES ( '$trade_code','$temp_code','$temp_price', '$temp_price',
		  				'$temp_name','$temp_kind', '$temp_count', '$temp_count', 
					  	'$id', '$temp_amount','$temp_count', '$today', '$memo' )";

$result = mysqli_query($connect, $query);

if(!$result){
   err_msg('데이터베이스 에러가 났습니다.');
}
else{
   echo "<meta http-equiv=\"content-type\" content=\"text/html; charset=UTF-8\" />
   		    <script type='text/javascript'>
			    alert('발주서를 등록했습니다.')
			</script>
            <meta http-equiv='Refresh' content='0; URL=offer_list.php'>"; 
}
?>
