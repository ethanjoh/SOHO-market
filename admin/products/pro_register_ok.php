<?php

include_once "../include/admin_auth.php";
include_once "../../util/util.php";

$mode     = set_var($_POST['mode']);
$lcode    = set_var($_POST['lcode']);
$mcode    = set_var($_POST['mcode']);
$p_num    = set_var($_POST['p_num']);
$page     = set_var($_POST['page']);
$contents = set_var($_POST['contents']);

$del_chk = set_var($_POST['del_chk']);
$event   = set_var($_POST['event']);
$date1   = set_var($_POST['date1']);
$date2   = set_var($_POST['date2']);

//$id = set_var($_POST['id']);
$name = set_var($_POST['name']);
$name = addslashes($name);

$short_desc = set_var($_POST['short_desc']);
$short_desc = nl2br($short_desc);
$company    = set_var($_POST['company']);
$company    = addslashes($company);
// $importer = set_var($_POST['importer']);
// $origin = set_var($_POST['origin']);

$shop_price   = set_var($_POST['shop_price']);
$shop_price   = trim($shop_price);
$retail_price = set_var($_POST['retail_price']);
$retail_price = trim($retail_price);

// $sale_price = set_var($_POST['sale_price']);
// $fixed_price = set_var($_POST['fixed_price']);
// $pflag = set_var($_POST['pflag']);
// $mileage = set_var($_POST['mileage']);
$moq           = set_var($_POST['moq']);
$optname_ins   = set_var($_POST['optname_ins']);
$opt           = addslashes($optname_ins);
$opt_stock_ins = set_var($_POST['opt_stock_ins']);
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

$option1_chk = set_var($_POST['option1_chk']);
$option2_chk = set_var($_POST['option2_chk']);
$option3_chk = set_var($_POST['option3_chk']);
$option4_chk = set_var($_POST['option4_chk']);
// $option5_chk = set_var($_POST['option5_chk']);

$main_new     = set_var($_POST['main_new']);
$main_special = set_var($_POST['main_special']);
$main_best    = set_var($_POST['main_best']);

// $origin = addslashes($origin);

$ca1_qry    = "SELECT * FROM products_category1 WHERE code='$lcode' ";
$ca1_result = mysqli_query($connect, $ca1_qry);

if ($ca1_result) {
    $ca1_row = mysqli_fetch_array($ca1_result);
    $id      = $ca1_row['id'];
} else {
    $id = "";
}

//아이콘 표시 옵션
if (empty($option1_chk)) {
    $option1_chk = "N";
} else {
    $option1_chk = "Y";
}

if (empty($option2_chk)) {
    $option2_chk = "N";
} else {
    $option2_chk = "Y";
}

if (empty($option3_chk)) {
    $option3_chk = "N";
} else {
    $option3_chk = "Y";
}

if (empty($option4_chk)) {
    $option4_chk = "N";
} else {
    $option4_chk = "Y";
}

// if (empty($option5_chk)) {
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

const MAX_SIZE = 1024000;

$saveDir = "../../upload/p_image/";

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

    // if (isset($_FILES['b_image1'])) {
    //     check_img_extension($_FILES['b_image1']['name']);

    //     $bImg1_chk   = "Y";
    //     $bigImg1File = $saveDir . $name . "/b/" . $_FILES['b_image1']['name'];
    //     $bigImg1Path = $saveDir . $name . "/b/";

    //     if (is_dir($bigImg1Path)) {
    //         move_uploaded_file($_FILES['b_image1']['tmp_name'], $bigImg1File);
    //     } else {
    //         mkdir($bigImg1Path, 0755, true);
    //         move_uploaded_file($_FILES['b_image1']['tmp_name'], $bigImg1File);
    //     }

    //     //썸네일 자동생성
    //     $sImg1_chk     = "Y";
    //     $smallImg1File = $saveDir . $name . "/s/" . $_FILES['b_image1']['name'];
    //     $smallImg1Path = $saveDir . $name . "/s/";

    //     if (is_dir($smallImg1Path)) {
    //         make_thumbnail($bigImg1Path . $_FILES['b_image1']['name'], 100, 100, $smallImg1Path . $_FILES['b_image1']['name']);
    //     } else {
    //         mkdir($smallImg1Path, 0755, true);
    //         make_thumbnail($bigImg1Path . $_FILES['b_image1']['name'], 100, 100, $smallImg1Path . $_FILES['b_image1']['name']);
    //     }

    // } else {
    //     $bImg1_chk     = "N";
    //     $sImg1_chk     = "N";
    //     $bigImg1File   = 'http://placehold.it/500x500';
    //     $smallImg1File = 'http://placehold.it/100x100';
    // }

    $bImg_chk     = array();
    $sImg_chk     = array();
    $bigImgFile   = array();
    $smallImgFile = array();

    if (isset($_FILES['b_image'])) {
        for ($i = 0; $i < count($_FILES['b_image']['name']); $i++) {

            // 업로드 파일을 확인합니다.
            list($result, $ext, $error_msg) = check_uploaded_file($i);
            if ($result) {
                $bImg_chk[$i]   = "Y";
                $bigImgPath     = $saveDir . $name . "/b/";
                $bigImgFile[$i] = $bigImgPath . $_FILES['b_image']['name'][$i];
                $tmp_name       = $_FILES['b_image']['tmp_name'][$i];
                $move_to        = $bigImgPath . $_FILES['b_image']['name'][$i];

                if (is_dir($bigImgPath)) {
                    move_uploaded_file($tmp_name, $move_to);
                } else {
                    mkdir($bigImgPath, 0755, true);
                    move_uploaded_file($tmp_name, $move_to);
                }

                //썸네일 자동생성
                $sImg_chk[$i]     = "Y";
                $smallImgPath     = $saveDir . $name . "/s/";
                $smallImgFile[$i] = $smallImgPath . $_FILES['b_image']['name'][$i];

                if (is_dir($smallImgPath)) {
                    make_thumbnail($bigImgPath . $_FILES['b_image']['name'][$i], 100, 100, $smallImgPath . $_FILES['b_image']['name'][$i]);
                } else {
                    mkdir($smallImgPath, 0755, true);
                    make_thumbnail($bigImgPath . $_FILES['b_image']['name'][$i], 100, 100, $smallImgPath . $_FILES['b_image']['name'][$i]);
                }

            }

        }

    } else {
        for ($i = 0; $i < 4; $i++) {
            $bImg_chk[$i]     = "N";
            $sImg_chk[$i]     = "N";
            $bigImgFile[$i]   = 'http://placehold.it/500x500';
            $smallImgFile[$i] = 'http://placehold.it/100x100';
        }
    }

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

    $stock = "999";

    $dbinsert1 = "INSERT INTO products(prod_code, category_l, category_m,
										name, short_desc, company, id, shop_price, retail_price,
										moq, opt, opt_stock,
										contents,
										s_image1, s_image1_name,
                                        s_image2, s_image2_name,
                                        s_image3, s_image3_name,
                                        s_image4, s_image4_name,
										b_image1, b_image1_name,
										b_image2, b_image2_name,
										b_image3, b_image3_name,
										b_image4, b_image4_name,
										created, main_new, main_special, main_best,
                                        option1_chk, option2_chk, option3_chk, option4_chk,
                                        del_chk)
			    		VALUES('$trade_code', '$lcode', '$mcode',
					  		 		'$name', '$short_desc', '$company', '$id', '$shop_price', '$retail_price',
				      		 		'$moq',  '$opt', '$opt_stock',
									'$contents',
					  		 		'$sImg_chk[0]', '$smallImgFile[0]',
                                    '$sImg_chk[1]', '$smallImgFile[1]',
                                    '$sImg_chk[2]', '$smallImgFile[2]',
                                    '$sImg_chk[3]', '$smallImgFile[3]',
					   		 		'$bImg_chk[0]', '$bigImgFile[0]',
							 		'$bImg_chk[1]', '$bigImgFile[1]',
							 		'$bImg_chk[2]', '$bigImgFile[2]',
							 		'$bImg_chk[3]', '$bigImgFile[3]',
							 		now(), '$main_new', '$main_special', '$main_best',
                                    '$option1_chk', '$option2_chk', '$option3_chk', '$option4_chk',
                                    '$del_chk')";
    $result1 = mysqli_query($connect, $dbinsert1);

    if ($result1) {

        // 업체별 구매가능 DB에 신상품 추가
        // $dbup    = "UPDATE buy_product SET pro_id=CONCAT_WS(',', '$trade_code', pro_id), available=CONCAT_WS(',','N', available), price=CONCAT_WS(',','0', price)";
        // $result2 = mysqli_query($connect, $dbup);

        $url = "top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&page=" . $page . "";
        show_msg('신규 상품을 등록했습니다.', $url);
    } else {
        err_msg('신규 상품 등록 중 DB오류가 발생했습니다.');
    }
    // 상품 업데이트
} else if ($mode == "update") {

    // $saveDir = "../../upload/p_image/" . $name;

    // $s_temp1_char = '';
    // $s_temp2_char = '';
    // $s_temp3_char = '';
    // $s_temp4_char = '';

    // $b_temp1_char = '';
    // $b_temp2_char = '';
    // $b_temp3_char = '';
    // $b_temp4_char = '';

    $s_temp_str   = array();
    $b_temp_str   = array();
    $bigImgFile   = array();
    $smallImgFile = array();

    if ($_FILES['b_image']['error'] > 0 && !isset($_FILES['b_image'])) {

        $query  = "SELECT * FROM products WHERE num='$p_num' ";
        $result = mysqli_query($connect, $query);
        $row    = mysqli_fetch_array($result);

        for ($i = 0; $i < 4; $i++) {
            $idx = $i + 1;

            $smallFlag      = "s_image" . $idx;
            $smallFlagVal   = $row[$smallFlag];
            $smallFileTitle = $smallFlag . "_name";
            $smallFileVal   = $row[$smallFileTitle];

            $bigFlag      = "b_image" . $idx;
            $bigFlagVal   = $row[$bigFlag];
            $bigFileTitle = $bigFlag . "_name";
            $bigFileVal   = $row[$bigFileTitle];

            $b_temp_str[$i] = ", " . $bigFlag . "='" . $bigFlagVal . "' , " . $bigFileTitle . "='" . $bigFileVal . "' ";
            $s_temp_str[$i] = ", " . $smallFlag . "='" . $smallFlagVal . "' , " . $smallFileTitle . "='" . $smallFileVal . "' ";

        }

    } else {

        $query  = "SELECT * FROM products WHERE num='$p_num' ";
        $result = mysqli_query($connect, $query);
        $row    = mysqli_fetch_array($result);

        for ($i = 0; $i < count($_FILES['b_image']['name']); $i++) {

            $idx = $i + 1;

            if ($_FILES['b_image']['name'][$i] == "") {
                $smallFlag      = "s_image" . $idx;
                $smallFlagVal   = $row[$smallFlag];
                $smallFileTitle = $smallFlag . "_name";
                $smallFileVal   = $row[$smallFileTitle];

                $bigFlag      = "b_image" . $idx;
                $bigFlagVal   = $row[$bigFlag];
                $bigFileTitle = $bigFlag . "_name";
                $bigFileVal   = $row[$bigFileTitle];

                $b_temp_str[$i] = ", " . $bigFlag . "='" . $bigFlagVal . "' , " . $bigFileTitle . "='" . $bigFileVal . "' ";
                $s_temp_str[$i] = ", " . $smallFlag . "='" . $smallFlagVal . "' , " . $smallFileTitle . "='" . $smallFileVal . "' ";
            }

            // 업로드 파일을 확인합니다.
            list($result, $ext, $error_msg) = check_uploaded_file($i);

            if ($result) {

                $bigImgPath     = $saveDir . $name . "/b/";
                $bigImgFile[$i] = $bigImgPath . $_FILES['b_image']['name'][$i];
                $tmp_name       = $_FILES['b_image']['tmp_name'][$i];
                $move_to        = $bigImgPath . $_FILES['b_image']['name'][$i];

                if (is_dir($bigImgPath)) {
                    move_uploaded_file($tmp_name, $move_to);
                } else {
                    mkdir($bigImgPath, 0755, true);
                    move_uploaded_file($tmp_name, $move_to);
                }

                $bigFlag        = "b_image" . $idx;
                $b_temp_str[$i] = ", " . $bigFlag . "='Y' , " . $bigFlag . "_name='" . $bigImgFile[$i] . "' ";

                //썸네일 자동생성
                $smallImgPath     = $saveDir . $name . "/s/";
                $smallImgFile[$i] = $smallImgPath . $_FILES['b_image']['name'][$i];

                if (is_dir($smallImgPath)) {
                    make_thumbnail($bigImgPath . $_FILES['b_image']['name'][$i], 100, 100, $smallImgPath . $_FILES['b_image']['name'][$i]);
                } else {
                    mkdir($smallImgPath, 0755, true);
                    make_thumbnail($bigImgPath . $_FILES['b_image']['name'][$i], 100, 100, $smallImgPath . $_FILES['b_image']['name'][$i]);
                }

                $smallFlag      = "s_image" . $idx;
                $s_temp_str[$i] = ", " . $smallFlag . "='Y' , " . $smallFlag . "_name='" . $smallImgFile[$i] . "' ";

            }

            if (count($error_msg) > 0) {
                foreach ($error_msg as $msg) {
                    msg($msg . "\n");
                }
            }

        }
    }

    // if ($_FILES['b_image1']['name']) {
    //     $b_temp1 = $saveDir . "/b/" . $_FILES['b_image1']['name'];
    //     move_uploaded_file($_FILES['b_image1']['tmp_name'], $b_temp1);
    //     $b_temp1_char = ", b_image1='Y' , b_image1_name='$b_temp1' ";

    //     //썸네일 자동생성
    //     $s_temp1 = $saveDir . "/s/" . $_FILES['b_image1']['name'];
    //     make_thumbnail($temp3, 100, 100, $s_temp1);
    //     move_uploaded_file($_FILES['b_image1']['tmp_name'], $s_temp1);
    //     $s_temp1_char = ", s_image1='Y' , s_image1_name='$s_temp1' ";
    // }

    // if ($_FILES['b_image2']['name']) {
    //     $b_temp2 = $saveDir . "/b/" . $_FILES['b_image2']['name'];
    //     move_uploaded_file($_FILES['b_image2']['tmp_name'], $b_temp2);
    //     $b_temp2_char = ", b_image2='Y' , b_image2_name='$b_temp2' ";

    //     //썸네일 자동생성
    //     $s_temp2 = $saveDir . "/s/" . $_FILES['b_image2']['name'];
    //     make_thumbnail($temp3, 100, 100, $s_temp2);
    //     move_uploaded_file($_FILES['b_image2']['tmp_name'], $s_temp2);
    //     $s_temp2_char = ", s_image2='Y' , s_image2_name='$s_temp2' ";
    // }

    // if ($_FILES['b_image3']['name']) {
    //     $b_temp3 = $saveDir . "/b/" . $_FILES['b_image3']['name'];
    //     move_uploaded_file($_FILES['b_image3']['tmp_name'], $b_temp3);
    //     $b_temp3_char = ", b_image3='Y' , b_image3_name='$b_temp3' ";

    //     //썸네일 자동생성
    //     $s_temp3 = $saveDir . "/s/" . $_FILES['b_image3']['name'];
    //     make_thumbnail($temp3, 100, 100, $s_temp3);
    //     move_uploaded_file($_FILES['b_image3']['tmp_name'], $s_temp3);
    //     $s_temp3_char = ", s_image3='Y' , s_image3_name='$s_temp3' ";
    // }

    // if ($_FILES['b_image4']['name']) {
    //     $b_temp4 = $saveDir . "/b/" . $_FILES['b_image4']['name'];
    //     move_uploaded_file($_FILES['b_image4']['tmp_name'], $b_temp4);
    //     $b_temp4_char = ", b_image4='Y' , b_image4_name='$b_temp4' ";

    //     //썸네일 자동생성
    //     $s_temp4 = $saveDir . "/s/" . $_FILES['b_image4']['name'];
    //     make_thumbnail($temp3, 100, 100, $s_temp4);
    //     move_uploaded_file($_FILES['b_image4']['tmp_name'], $s_temp4);
    //     $s_temp4_char = ", s_image4='Y' , s_image4_name='$s_temp4' ";
    // }

    // $name    = addslashes($name);
    // $company = addslashes($company);
    // // $origin = addslashes($origin);
    // $opt = addslashes($optname_ins);
    // //$opt_stock = addslashes($opt_stock_ins);
    // $short_desc = nl2br($short_desc);

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

    $dbinsert1 = "UPDATE products SET category_l      = '$lcode',
                                         category_m   = '$mcode' ,
										 name         = '$name',
										 short_desc   = '$short_desc',
										 company      = '$company',
										 id           = '$id',
                                         shop_price   = '$shop_price',
										 retail_price = '$retail_price',
										 moq          = '$moq',
										 opt          = '$opt',
										 opt_stock    = '$opt_stock',
										 contents     = '$contents'
										 $s_temp_str[0]
                                         $s_temp_str[1]
                                         $s_temp_str[2]
                                         $s_temp_str[3]
										 $b_temp_str[0]
										 $b_temp_str[1]
										 $b_temp_str[2]
										 $b_temp_str[3],
										 modified     = now(),
										 main_new     = '$main_new',
										 main_special = '$main_special',
										 main_best    = '$main_best',
                                         option1_chk  = '$option1_chk',
                                         option2_chk  = '$option2_chk',
                                         option3_chk  = '$option3_chk',
                                         option4_chk  = '$option4_chk',
										 del_chk      = '$del_chk'
					  WHERE num='$p_num' ";
    $result1 = mysqli_query($connect, $dbinsert1);

    // debug
    $txt  = print_r($dbinsert1, true);
    $file = fopen("log.txt", "w+");
    fwrite($file, $txt);
    fclose($file);

    if ($result1) {
        $url = "top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&page=" . $page . "";
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

    $sql = "INSERT INTO products(prod_code, category_l, category_m,
								name, short_desc, company, id, shop_price, retail_price,
								moq, opt, opt_stock,
								contents,
								created, main_new, main_special, main_best,
								del_chk)
			    		VALUES('$trade_code', '$row1[category_l]', '$row1[category_m]',
				  		 		'$row1[name]', '$row1[short_desc]', '$row1[company]', '$row1[id]', '$row1[shop_price]', '$row1[retail_price]',
			      		 		'$row1[moq]', '', '',
								'$row1[contents]',
						 		now(), '$row1[main_new]', '$row1[main_special]', '$row1[main_best]',
								'$row1[del_chk]')";
    $result2 = mysqli_query($connect, $sql);

    if ($result2) {
        $url = "pro_register.php?mode=update&prod_code=" . $trade_code . "&lcode=" . $row1['category_l'] . "&mcode=" . $row1['category_m'] . "&page=" . $page . "&flag=1";
        show_msg('상품을 복사했습니다.', $url);
    } else {
        err_msg('상품 복사 중 DB오류가 발생했습니다.');
    }
}
