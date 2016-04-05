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

$name = set_var($_POST['name']);
$name = addslashes($name);

$short_desc = set_var($_POST['short_desc']);
$short_desc = nl2br($short_desc);
$company    = set_var($_POST['company']);
$company    = addslashes($company);

$shop_price   = set_var($_POST['shop_price']);
$shop_price   = trim($shop_price);
$retail_price = set_var($_POST['retail_price']);
$retail_price = trim($retail_price);

$moq           = set_var($_POST['moq']);
$optname_ins   = set_var($_POST['optname_ins']);
$opt           = addslashes($optname_ins);
$opt_stock_ins = set_var($_POST['opt_stock_ins']);
$optname       = set_var($_POST['optname']);
$optstock      = set_var($_POST['opt_stock']);

$option1_chk = set_var($_POST['option1_chk']);
$option2_chk = set_var($_POST['option2_chk']);
$option3_chk = set_var($_POST['option3_chk']);
$option4_chk = set_var($_POST['option4_chk']);

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

const MAX_SIZE = 1024000;

$saveDir = "../../upload/p_image/";

//신규 상품 등록
if ($mode == "insert") {

    $bImg_chk     = array();
    $sImg_chk     = array();
    $bigImgFile   = array();
    $smallImgFile = array();

    if (isset($_FILES['b_image'])) {
        for ($i = 0; $i < count($_FILES['b_image']['name']); $i++) {

            if ($_FILES['b_image']['name'][$i] == "") {
                $bImg_chk[$i]     = "N";
                $sImg_chk[$i]     = "N";
                $bigImgFile[$i]   = '';
                $smallImgFile[$i] = '';
            }

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

    $stock     = "999";
    $item_code = generate_item_code();

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
			    		VALUES('$item_code', '$lcode', '$mcode',
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
        $url = "top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&page=" . $page . "";
        show_msg('신규 상품을 등록했습니다.', $url);
    } else {
        err_msg('신규 상품 등록 중 DB오류가 발생했습니다.');
    }
    // 상품 업데이트
} else if ($mode == "update") {

    $s_temp_str   = array();
    $b_temp_str   = array();
    $bigImgFile   = array();
    $smallImgFile = array();

    // 에러 발생 시
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

            // 수정 시 파일이 업로드 되지 않은 경우 기존 상태유지
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
    // $txt  = print_r($dbinsert1, true);
    // $file = fopen("log.txt", "w+");
    // fwrite($file, $txt);
    // fclose($file);

    if ($result1) {
        $url = "top_pro_list.php?lcode=" . $lcode . "&mcode=" . $mcode . "&page=" . $page . "";
        show_msg('상품 등록정보를 수정했습니다.', $url);
    } else {
        err_msg('상품 수정 중 DB오류가 발생했습니다.');
    }
    // 상품 복사
} else if ($mode == "copy") {

    $item_code = generate_item_code();

    $query1  = "SELECT * FROM products WHERE num='$p_num' ";
    $result1 = mysqli_query($connect, $query1);
    $row1    = mysqli_fetch_array($result1);

    $sql = "INSERT INTO products(prod_code, category_l, category_m,
								company, shop_price, retail_price,
								moq,
								contents,
								created, main_new, main_special, main_best,
								del_chk)
			    		VALUES('" . $item_code . "', '" . $row1['category_l'] . "', '" . $row1['category_m'] . "',
				  		 		'" . $row1['company'] . "', '" . $row1['shop_price'] . "', '" . $row1['retail_price'] . "',
			      		 		'" . $row1['moq'] . "',
								'" . $row1['contents'] . "',
						 		now(), '" . $row1['main_new'] . "', '" . $row1['main_special'] . "', '" . $row1['main_best'] . "',
								'" . $row1['del_chk'] . "')";
    $result2 = mysqli_query($connect, $sql);

    if ($result2) {
        $new_p_num = mysqli_insert_id($connect);
        $url       = "pro_register.php?mode=update&p_num=" . $new_p_num . "&lcode=" . $row1['category_l'] . "&mcode=" . $row1['category_m'] . "&page=" . $page . "";
        show_msg('상품을 복사했습니다.', $url);
    } else {
        err_msg('상품 복사 중 DB오류가 발생했습니다.');
    }
}
