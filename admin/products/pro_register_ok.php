<?php
//관리자 인증 파일
include "../../util/admin_auth.php";
// 데이타베이스 연결정보 및 기타설정
include "../../util/config.php";
// 각종 유틸함수
include "../../util/util.php";
// MySQL 연결
$connect = my_connect($host, $dbid, $dbpass, $dbname);

$mode  = set_var($_POST['mode']);
$p_num = set_var($_POST['p_num']);
$page  = set_var($_POST['page']);

$del_chk = set_var($_POST['del_chk']);
// $event = set_var($_POST['event']);
// $date1 = set_var($_POST['date1']);
// $date2 = set_var($_POST['date2']);

//$id = set_var($_POST['id']);
$name       = set_var($_POST['name']);
$short_desc = set_var($_POST['short_desc']);
$company    = set_var($_POST['company']);
// $importer = set_var($_POST['importer']);
// $origin = set_var($_POST['origin']);
$retail_price = set_var($_POST['retail_price']);
// $sale_price = set_var($_POST['sale_price']);
// $fixed_price = set_var($_POST['fixed_price']);
// $pflag = set_var($_POST['pflag']);
// $mileage = set_var($_POST['mileage']);
$moq         = set_var($_POST['moq']);
$optname_ins = set_var($_POST['optname_ins']);
//$opt_stock_ins = set_var($_POST['opt_stock_ins']);
// $barcode_ins = set_var($_POST['barcode_ins']);
$optname  = set_var($_POST['optname']);
$optstock = set_var($_POST['opt_stock']);
// $barcode = set_var($_POST['barcode']);
// $size = set_var($_POST['size']);
// $material = set_var($_POST['material']);
// $auth = set_var($_POST['auth']);
// $service = set_var($_POST['service']);
// $warranty = set_var($_POST['warranty']);
// $caution = set_var($_POST['caution']);

// $stock = set_var($_POST['stock']);
// $tag = set_var($_POST['tag']);
// $restock_date = set_var($_POST['restock_date']);
// $no_restock = set_var($_POST['no_restock']);

// $option1_chk = set_var($_POST['option1_chk']);
// $option2_chk = set_var($_POST['option2_chk']);
// $option3_chk = set_var($_POST['option3_chk']);
// $option4_chk = set_var($_POST['option4_chk']);
// $option5_chk = set_var($_POST['option5_chk']);

$main_new     = set_var($_POST['main_new']);
$main_special = set_var($_POST['main_special']);
$main_best    = set_var($_POST['main_best']);

$ca1_qry    = "SELECT * FROM products_category1 WHERE code='$lcode' ";
$ca1_result = mysqli_query($connect, $ca1_qry);
if ($ca1_result) {
    $ca1_row = mysqli_fetch_array($ca1_result);
    $id      = $ca1_row['id'];
} else {
    $id = "";
}

//아이콘 표시 옵션
// if(empty($option1_chk)){
//     $option1_chk = "N";
// } else {
//     $option1_chk = "Y";
// }

// if(empty($option2_chk)){
//     $option2_chk = "N";
// } else {
//     $option2_chk = "Y";
// }

// if(empty($option3_chk)){
//     $option3_chk = "N";
// } else {
//     $option3_chk = "Y";
// }

// if(empty($option4_chk)){
//     $option4_chk = "N";
// } else {
//     $option4_chk = "Y";
// }

// if(empty($option5_chk)){
//     $option5_chk = "N";
// } else {
//     $option5_chk = "Y";
// }

//메인화면 표시 옵션
if (empty($main_new)) {
    $main_new = "N";
} else {
    $main_new = "Y";
}

if (empty($main_special)) {
    $main_special = "N";
} else {
    $main_special = "Y";
}

if (empty($main_best)) {
    $main_best = "N";
} else {
    $main_best = "Y";
}

//특별 고정공급가 체크
// if(empty($pflag)){
//     $pflag = "N";
// } else {
//     $pflag = "Y";
// }

//재입고일이 미정일 경우
// if($no_restock == "Y")
//     $restock_date = "1111-00-00";

//공통 체크사항
/*
if($_FILES['s_image']['name']){
$file_ext1 = substr(strrchr($_FILES['s_image']['name'],"."), 1);
$file_ext1 = strtolower($file_ext1);

if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png'  ){
err_msg("이미지 파일만 올릴 수 있습니다.");
}
if (!$_FILES['s_image']['size']) {
err_msg("지정한 파일(소)이 없거나 파일 크기가 0KB입니다.");
}
}
 */

if ($_FILES['b_image1']['name']) {
    $file_ext3 = substr(strrchr($_FILES['b_image1']['name'], "."), 1);
    $file_ext3 = strtolower($file_ext3);

    if ($file_ext3 != 'jpg' && $file_ext3 != 'gif' && $file_ext3 != 'jpeg' && $file_ext3 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['b_image1']['size']) {
        err_msg("지정한 파일(확대1)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['b_image2']['name']) {
    $file_ext4 = substr(strrchr($_FILES['b_image2']['name'], "."), 1);
    $file_ext4 = strtolower($file_ext4);
    if ($file_ext4 != 'jpg' && $file_ext4 != 'gif' && $file_ext4 != 'jpeg' && $file_ext4 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['b_image2']['size']) {
        err_msg("지정한 파일(확대2)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['b_image3']['name']) {
    $file_ext5 = substr(strrchr($_FILES['b_image3']['name'], "."), 1);
    $file_ext5 = strtolower($file_ext5);
    if ($file_ext5 != 'jpg' && $file_ext5 != 'gif' && $file_ext5 != 'jpeg' && $file_ext5 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['b_image3']['size']) {
        err_msg("지정한 파일(확대3)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['b_image4']['name']) {
    $file_ext6 = substr(strrchr($_FILES['b_image4']['name'], "."), 1);
    $file_ext6 = strtolower($file_ext6);
    if ($file_ext6 != 'jpg' && $file_ext6 != 'gif' && $file_ext6 != 'jpeg' && $file_ext6 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['b_image4']['size']) {
        err_msg("지정한 파일(확대4)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['b_image5']['name']) {
    $file_ext7 = substr(strrchr($_FILES['b_image5']['name'], "."), 1);
    $file_ext7 = strtolower($file_ext7);
    if ($file_ext7 != 'jpg' && $file_ext7 != 'gif' && $file_ext7 != 'jpeg' && $file_ext7 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['b_image5']['size']) {
        err_msg("지정한 파일(확대5)이 없거나 파일 크기가 0KB입니다.");
    }
}

if ($_FILES['d_image']['name']) {
    $file_ext8 = substr(strrchr($_FILES['d_image']['name'], "."), 1);
    $file_ext8 = strtolower($file_ext8);
    if ($file_ext8 != 'jpg' && $file_ext8 != 'gif' && $file_ext8 != 'jpeg' && $file_ext8 != 'png') {
        err_msg("이미지 파일만 올릴 수 있습니다.");
    }
    if (!$_FILES['d_image']['size']) {
        err_msg("지정한 파일(상세)이 없거나 파일 크기가 0KB입니다.");
    }
}

//신규 상품 등록
if ($mode == "insert") {

    $query = "INSERT INTO products_code VALUES ('')";
    mysqli_query($connect, $query);

    $query  = "SELECT max(num) AS maxid FROM products_code";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $p_code     = $row['maxid'];
    $wdate      = date('md');
    $trade_code = "p" . $wdate . "-" . $p_code;

    $savedir = "../../upload/p_image";

    /*
    if($_FILES['s_image']['name']){
    $file1 = $savedir."/s/".substr(md5(uniqid($g4[server_time])),0,8)."_".$_FILES['s_image']['name'];
    move_uploaded_file($_FILES['s_image']['tmp_name'], $file1);
    $simg_chk = "Y";
    } else{
    $simg_chk = "N";
    }
     */

    if ($_FILES['b_image1']['name']) {
        $file3 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image1']['name'];
        move_uploaded_file($_FILES['b_image1']['tmp_name'], $file3);
        $bimg1_chk = "Y";

        //썸네일 자동생성
        $simg_chk = "Y";
        $file1    = $savedir . "/s/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image1']['name'];
        make_thumbnail($file3, 100, 100, $file1);
        move_uploaded_file($_FILES['b_image1']['tmp_name'], $file1);

    } else {
        $bimg1_chk = "N";
        $simg_chk  = "N";
    }

    if ($_FILES['b_image2']['name']) {
        $file4 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image2']['name'];
        move_uploaded_file($_FILES['b_image2']['tmp_name'], $file4);
        $bimg2_chk = "Y";
    } else {
        $bimg2_chk = "N";
    }

    if ($_FILES['b_image3']['name']) {
        $file5 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image3']['name'];
        move_uploaded_file($_FILES['b_image3']['tmp_name'], $file5);
        $bimg3_chk = "Y";
    } else {
        $bimg3_chk = "N";
    }

    if ($_FILES['b_image4']['name']) {
        $file6 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image4']['name'];
        move_uploaded_file($_FILES['b_image4']['tmp_name'], $file6);
        $bimg4_chk = "Y";
    } else {
        $bimg4_chk = "N";
    }

    if ($_FILES['b_image5']['name']) {
        $file7 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image5']['name'];
        move_uploaded_file($_FILES['b_image5']['tmp_name'], $file7);
        $bimg5_chk = "Y";
    } else {
        $bimg5_chk = "N";
    }

    if ($_FILES['d_image']['name']) {
        $file8 = $savedir . "/d/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['d_image']['name'];
        move_uploaded_file($_FILES['d_image']['tmp_name'], $file8);
        $dimg_chk = "Y";
    } else {
        $dimg_chk = "N";
    }

    $name    = addslashes($name);
    $company = addslashes($company);
    // $origin = addslashes($origin);
    $opt        = addslashes($optname_ins);
    $short_desc = nl2br($short_desc);

    $t_opt = explode(",", $optname_ins); //배열로 만들어준다

    //옵션 갯수만큼 옵션재고관리 자동입력
    for ($i = 0; $i < count($t_opt); $i++) {
        if ($i == 0) {
            $opt_stock = "1";
        } else {
            $opt_stock .= ",1";
        }

    }

    if ($moq == "") {
        $moq = "1";
    }

    if ($stock == "") {
        $stock = "100";
    }

    $dbinsert1 = "INSERT INTO products(prod_code, category_l,
										name, short_desc, company, id, retail_price,
										moq, opt, opt_stock,
										contents,
										s_image,   s_image_name,
										b_image1, b_image1_name,
										b_image2, b_image2_name,
										b_image3, b_image3_name,
										b_image4, b_image4_name,
										b_image5, b_image5_name,
										d_image,  d_image_name,
										created, main_new, main_special, main_best, del_chk)
			    		VALUES('$trade_code', '$lcode',
					  		 		'$name', '$short_desc', '$company', '$id', '$retail_price',
				      		 		'$moq',  '$opt', '$opt_stock',
									'$contents',
					  		 		'$simg_chk',  '$file1',
					   		 		'$bimg1_chk', '$file3',
							 		'$bimg2_chk', '$file4',
							 		'$bimg3_chk', '$file5',
							 		'$bimg4_chk', '$file6',
							 		'$bimg5_chk', '$file7',
							 		'$dimg_chk',  '$file8',
							 		now(), '$main_new', '$main_special', '$main_best', '$del_chk')";
    $result1 = mysqli_query($connect, $dbinsert1);

    if ($result1) {

        // 업체별 구매가능 DB에 신상품 추가
        $dbup    = "UPDATE buy_product SET pro_id=CONCAT_WS(',', '$trade_code', pro_id), available=CONCAT_WS(',','N', available), price=CONCAT_WS(',','0', price)";
        $result2 = mysqli_query($connect, $dbup);

        $url = "top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode . "&page=" . $page . "";
        show_msg('상품을 등록했습니다.', $url);
    } else {
        err_msg('상품 등록 중 DB오류가 발생했습니다.');
    }
    // 상품 업데이트
} else if ($mode == "update") {
    if ($prod_code) {
        $chg = "prod_code=" . "'" . $prod_code . "'";
    } else {
        $chg = "num=" . $p_num;
    }

    $query  = "SELECT * FROM products WHERE $chg ";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);
    mysqli_free_result($result);

    $savedir = "../../upload/p_image";

    if ($_FILES['b_image1']['name']) {
        $temp3 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image1']['name'];
        move_uploaded_file($_FILES['b_image1']['tmp_name'], $temp3);
        $temp3_char = ", b_image1='Y' , b_image1_name='$temp3' ";

        //썸네일 자동생성
        $temp1 = $savedir . "/s/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image1']['name'];
        make_thumbnail($temp3, 100, 100, $temp1);
        move_uploaded_file($_FILES['b_image1']['tmp_name'], $temp1);
        $temp1_char = ", s_image='Y' , s_image_name='$temp1' ";
    }

    if ($_FILES['b_image2']['name']) {
        $temp4 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image2']['name'];
        move_uploaded_file($_FILES['b_image2']['tmp_name'], $temp4);
        $temp4_char = ", b_image2='Y' , b_image2_name='$temp4' ";
    }

    if ($_FILES['b_image3']['name']) {
        $temp5 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image3']['name'];
        move_uploaded_file($_FILES['b_image3']['tmp_name'], $temp5);
        $temp5_char = ", b_image3='Y' , b_image3_name='$temp5' ";
    }

    if ($_FILES['b_image4']['name']) {
        $temp6 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image4']['name'];
        move_uploaded_file($_FILES['b_image4']['tmp_name'], $temp6);
        $temp6_char = ", b_image4='Y' , b_image4_name='$temp6' ";
    }

    if ($_FILES['b_image5']['name']) {
        $temp7 = $savedir . "/b/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['b_image5']['name'];
        move_uploaded_file($_FILES['b_image5']['tmp_name'], $temp7);
        $temp7_char = ", b_image5='Y' , b_image5_name='$temp7' ";
    }

    if ($_FILES['d_image']['name']) {
        $temp8 = $savedir . "/d/" . substr(md5(uniqid($g4[server_time])), 0, 8) . "_" . $_FILES['d_image']['name'];
        move_uploaded_file($_FILES['d_image']['tmp_name'], $temp8);
        $temp8_char = ", d_image='Y' , d_image_name='$temp8' ";
    }

    $name    = addslashes($name);
    $company = addslashes($company);
    // $origin = addslashes($origin);
    $opt = addslashes($optname_ins);
    //$opt_stock = addslashes($opt_stock_ins);
    $short_desc = nl2br($short_desc);

    $t_opt = explode(",", $optname_ins); //배열로 만들어준다

    //옵션 갯수만큼 옵션재고관리 자동입력
    for ($i = 0; $i < count($t_opt); $i++) {
        if ($i == 0) {
            $opt_stock = "1";
        } else {
            $opt_stock .= ",1";
        }

    }

    if ($optname != null) {
        $opt       = implode(",", $optname);
        $opt_stock = implode(",", $optstock);
        // $barcode = implode(",", $barcode);
    }
    //$contents = addslashes($contents);

    // if($del_chk == "O") {
    //     $stock = "0";
    // }

    $dbinsert1 = "UPDATE products SET category_l='$lcode',
										 name='$name',
										 short_desc='$short_desc',
										 company='$company',
										 id='$id',
										 retail_price='$retail_price',
										 moq='$moq',
										 opt='$opt',
										 opt_stock = '$opt_stock',
										 contents='$contents'
										 $temp1_char
										 $temp3_char
										 $temp4_char
										 $temp5_char
										 $temp6_char
										 $temp7_char
										 $temp8_char ,
										 modified=now(),
										 main_new = '$main_new',
										 main_special = '$main_special',
										 main_best = '$main_best',
										 del_chk='$del_chk'
					  WHERE $chg ";
    $result1 = mysqli_query($connect, $dbinsert1);

    if ($result1) {
        $url = "top_pro_list.php?pmode=" . $pmode . "&lcode=" . $lcode . "&mcode=" . $mcode . "&scode=" . $scode . "&page=" . $page . "";
        show_msg('상품 등록정보를 수정했습니다.', $url);
    } else {
        err_msg('상품 수정 중 DB오류가 발생했습니다.');
    }
    // 상품 복사
} else if ($mode == "copy") {

    $query = "INSERT INTO products_code VALUES ('')";
    mysqli_query($connect, $query);

    $query  = "SELECT max(num) AS maxid FROM products_code";
    $result = mysqli_query($connect, $query);
    $row    = mysqli_fetch_array($result);

    $p_code     = $row['maxid'];
    $wdate      = date('md');
    $trade_code = "p" . $wdate . "-" . $p_code;

    $query1  = "SELECT * FROM products WHERE num='$p_num' ";
    $result1 = mysqli_query($connect, $query1);
    $row1    = mysqli_fetch_array($result1);

    $sql = "INSERT INTO products(prod_code, category_l,
								name, short_desc, company, id, retail_price,
								moq, opt, opt_stock,
								contents,
								created, main_new, main_special, main_best,
								del_chk)
			    		VALUES('$trade_code', '$row1[category_l]',
				  		 		'$row1[name]', '$row1[short_desc]', '$row1[company]', '$row1[id]', '$row1[retail_price]',
			      		 		'$row1[moq]', '', '',
								'$row1[contents]',
						 		now(), '$row1[main_new]', '$row1[main_special]', '$row1[main_best]',
								'$row1[del_chk]')";
    $result2 = mysqli_query($connect, $sql);

    if ($result2) {
        $url = "pro_register.php?mode=update&prod_code=" . $trade_code . "&lcode=" . $row1['category_l'] . "&mcode=" . $row1['category_m'] . "&scode=" . $row1['category_s'] . "&page=" . $page . "&flag=1";
        show_msg('상품을 복사했습니다.', $url);
    } else {
        err_msg('상품 복사 중 DB오류가 발생했습니다.');
    }
}
