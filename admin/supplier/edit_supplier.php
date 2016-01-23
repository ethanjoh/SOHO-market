<?

include "../../util/admin_auth.php";

include "../../util/config.php";

include "../../util/util.php";

$connect=my_connect($host,$dbid,$dbpass,$dbname);

$passwd 		= set_var($_POST['passwd']);
$md_email 		= set_var($_POST['md_email']);
$md_name 		= set_var($_POST['md_name']);
$md_hphone1 	= set_var($_POST['md_hphone1']);
$md_hphone2 	= set_var($_POST['md_hphone2']);
$md_hphone3 	= set_var($_POST['md_hphone3']);
$company_name 	= set_var($_POST['company_name']);
$ceo 			= set_var($_POST['ceo']);
$license_no1 	= set_var($_POST['license_no1']);
$license_no2 	= set_var($_POST['license_no2']);
$license_no3 	= set_var($_POST['license_no3']);
$o_zipcode1 	= set_var($_POST['o_zipcode1']);
$o_zipcode2 	= set_var($_POST['o_zipcode2']);
$o_addr1 		= set_var($_POST['o_addr1']);
$o_addr2 		= set_var($_POST['o_addr2']);
$o_phone1 		= set_var($_POST['o_phone1']);
$o_phone2 		= set_var($_POST['o_phone2']);
$o_phone3 		= set_var($_POST['o_phone3']);
$o_fax1 		= set_var($_POST['o_fax1']);
$o_fax2 		= set_var($_POST['o_fax2']);
$o_fax3 		= set_var($_POST['o_fax3']);
$category1 		= set_var($_POST['category1']);
$category2 		= set_var($_POST['category2']);
$homepage 		= set_var($_POST['homepage']);
$d_zipcode1 	= set_var($_POST['d_zipcode1']);
$d_zipcode2 	= set_var($_POST['d_zipcode2']);
$d_addr1 		= set_var($_POST['d_addr1']);
$d_addr2 		= set_var($_POST['d_addr2']);
$d_phone1 		= set_var($_POST['d_phone1']);
$d_phone2 		= set_var($_POST['d_phone2']);
$d_phone3 		= set_var($_POST['d_phone3']);
$d_fax1 		= set_var($_POST['d_fax1']);
$d_fax2 		= set_var($_POST['d_fax2']);
$d_fax3 		= set_var($_POST['d_fax3']);
$seller 		= set_var($_POST['seller']);
$margin 		= set_var($_POST['margin']);
$tax 			= set_var($_POST['tax']);
$payment_day 	= set_var($_POST['payment_day']);
$approved 		= set_var($_POST['approved']);

$license_no 	= $license_no1."-".$license_no2."-".$license_no3;
$md_email 		= addslashes($md_email);
$md_hphone 		= $md_hphone1."-".$md_hphone2."-".$md_hphone3;
$o_phone 		= $o_phone1."-".$o_phone2."-".$o_phone3;
$o_fax 			= $o_fax1."-".$o_fax2."-".$o_fax3;
$d_phone 		= $d_phone1."-".$d_phone2."-".$d_phone3;
$d_fax 			= $d_fax1."-".$d_fax2."-".$d_fax3;

$o_zipcode 		= $o_zipcode1."-".$o_zipcode2;
$d_zipcode 		= $d_zipcode1."-".$d_zipcode2;
$o_addr1 		= addslashes($o_addr1);
$o_addr2 		= addslashes($o_addr2);
$d_addr1 		= addslashes($d_addr1);
$d_addr2 		= addslashes($d_addr2);

$seller_type 	= $seller[0];
$payment_type 	= $payment_day[0];
$approved_type 	= $approved[0];
$tax 			= $tax[0];

if($passwd) {
  $passwd = sha1($passwd);
} else {
  $qry = "SELECT * FROM supplier WHERE seq_num='$num' ";
  $res = mysqli_query($connect, $qry);
  $row = mysqli_fetch_array($res);

  $passwd = $row['passwd'];
}

$query1 = "UPDATE supplier SET passwd = '$passwd',
								md_email = '$md_email',
								md_name = '$md_name',
								md_hphone = '$md_hphone',
								company_name = '$company_name',
								license_no = '$license_no',
								ceo = '$ceo',
								o_zipcode = '$o_zipcode',
								o_addr1 = '$o_addr1',
								o_addr2 = '$o_addr2',
								o_phone = '$o_phone',
								o_fax = '$o_fax',
								category1 = '$category1',
								category2 = '$category2',
								homepage = '$homepage',
								d_zipcode = '$d_zipcode',
								d_addr1 = '$d_addr1',
								d_addr2 = '$d_addr2',
								d_phone = '$d_phone',
								d_fax = '$d_fax',
								seller = '$seller_type',
								margin = '$margin',
								tax = '$tax',
								payment_day = '$payment_type',
								approved = '$approved_type'
		  WHERE seq_num='$num' ";

$result1 = mysqli_query($connect, $query1);

if (!$result1) {
	err_msg('DB 오류가 발생했습니다.');
}
else {
   echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
     	   <script>
        	window.alert('정상적으로 수정했습니다.')
	       </script> ";
    echo "<meta http-equiv='Refresh' content='0;  URL=http://www.$_SERVER[SERVER_NAME]/admin/supplier/view_supplier.php?num=$num&amp;page=$page'>";
   }
?>
