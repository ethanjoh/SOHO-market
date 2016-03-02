<?php
// 상품정보 업로드하기
// get-product.php?f=[csv 파일명]
// csv 파일은 upload 폴더에 위치
// 상품 이미지는 img 폴더에 위치

include "util/util.php";

if ($_GET) {
    $filename = $_GET['f'];
} else {
    echo "no specified file";
    exit;
}

$uploaddir = "upload/" . $filename . ".csv";

//hosting information
$host = "localhost";
$dbid = "ssss01047271791";
$dbpw = "Shinsoo19931008";
$db   = "ssss01047271791";

//connect local db
$connect = mysqli_connect($host, $dbid, $dbpw);
mysqli_select_db($connect, $db);
// mysqli_query($connect, "TRUNCATE TABLE products");

$tempCSV = file_get_contents($uploaddir);
$tempCSV = mb_convert_encoding($tempCSV, 'UTF-8', 'EUC-KR');

$fp = tmpfile();
fwrite($fp, $tempCSV);
rewind($fp);
setlocale(LC_ALL, 'ko_KR.UTF-8');

// $fp = fopen("$uploaddir", "r");

$line = 1;

// while ($data = fgetcsv($fp, 4000, ",")) {
while ($data = fgetcsv($fp)) {

    echo "<pre>";
    print_r($data);
    echo "</pre>";

    // data[1]: 상품코드, data[2]: 상품명, data[3]: 공급가, data[4]:이미지, data[5]:분류,
    // data[6]: 모델번호, data[7]: 브랜드, data[8]: 규격

    //상품코드
    $prod_code = trim($data['1']);
    $lcode     = "1";

    // 모델번호 =>상품명
    $name = addslashes(trim($data['6']));

    // 상품명=>간략설명
    $short_desc = trim($data['2']);

    // 브랜드
    $company = trim($data['7']);

    // 아이디
    $id = "admin";

    // 수입공급자
    $importer = "신수상사";

    // 공급가
    $retail_price = trim($data['3']);

    //DB에 저장할 이미지 저장 경로
    $savedir = "../../upload/p_image/";

    // 분류에 따라 저장
    if (trim($data['5']) == '아이언/우드그립' || trim($data['5']) == '클럽그립') {
        $mcode     = "1";
        $bimg1_chk = "Y";
        $file3     = $savedir . $data['6'] . "/b/" . $data['4'];

        // 생성할 디렉토리명은 모델번호로 지정
        $dir = "upload/p_image/" . $data['6'] . "/b/";
        if (is_dir($dir)) {
            echo "<p>directory " . $dir . " is already exists.</p>\n";
        } else {
            if (mkdir($dir, 0755, true)) {
                echo "<p>directory " . $dir . " is created successfully.</p>\n";
            } else {
                echo "<p>directory " . $dir . " is failed to create.</p>\n";
            }
        }

        copy("img/iron/" . $data['4'], $dir . $data['4']);

        //썸네일 자동생성
        $dir2 = "upload/p_image/" . $data['6'] . "/s/";
        if (is_dir($dir2)) {
            echo "<p>directory " . $dir2 . " is already exists.</p>\n";
        } else {
            if (mkdir($dir2, 0755, true)) {
                echo "<p>directory " . $dir2 . " is created successfully.</p>\n";
            } else {
                echo "<p>directory " . $dir2 . " is failed to create.</p>\n";
            }
        }
        $simg_chk = "Y";
        $file1    = $savedir . $data['6'] . "/s/" . $data['4'];
        make_thumbnail($dir . $data['4'], 100, 100, $dir2 . $data['4']);

    } elseif (trim($data['5']) == '퍼터그립') {
        $mcode     = "2";
        $bimg1_chk = "Y";
        $file3     = $savedir . "/b/" . $data['4'];

        // 생성할 디렉토리명은 모델번호로 지정
        $dir = "upload/p_image/" . $data['5'] . "/b/";
        if (is_dir($dir)) {
            echo "<p>directory " . $dir . " is already exists.</p>\n";
        } else {
            if (mkdir($dir, 0755, true)) {
                echo "<p>directory " . $dir . " is created successfully.</p>\n";
            } else {
                echo "<p>directory " . $dir . " is failed to create.</p>\n";
            }
        }

        copy("img/putter/" . $data['4'], $dir . $data['4']);

        //썸네일 자동생성
        $dir2 = "upload/p_image/" . $data['5'] . "/s/";
        if (is_dir($dir2)) {
            echo "<p>directory " . $dir2 . " is already exists.</p>\n";
        } else {
            if (mkdir($dir2, 0755, true)) {
                echo "<p>directory " . $dir2 . " is created successfully.</p>\n";
            } else {
                echo "<p>directory " . $dir2 . " is failed to create.</p>\n";
            }
        }
        $simg_chk = "Y";
        $file1    = $savedir . $data['5'] . "/s/" . $data['4'];
        make_thumbnail($dir . $data['4'], 100, 100, $dir2 . $data['4']);
    } else {
        $bimg1_chk = "N";
        $file3     = "";
    }

    $d_image = "N";

    // 재고
    $stock   = "999";
    $del_chk = "N";

    //content
    // $contents = htmlspecialchars($data['16'], ENT_QUOTES);

    //spcode
    $main_new     = "N";
    $main_special = "N";
    $main_best    = "N";

    $option1_chk = "N";
    $option2_chk = "N";
    $option3_chk = "N";
    $option4_chk = "N";
    $option5_chk = "N";

    // 규격=>옵션
    $opt       = trim($data['8']);
    $opt_stock = '1';

    $event = "0";

    //approval status
    $approved = "Y";

    $moq = "1";

    $sql = "INSERT INTO products(prod_code, category_l, category_m,
								name, short_desc, company, importer, id, retail_price,
								moq, opt, opt_stock,stock,
    							s_image,   s_image_name,
    							b_image1, b_image1_name,
    							b_image2, b_image2_name,
    							b_image3, b_image3_name,
    							b_image4, b_image4_name,
    							b_image5, b_image5_name,
    							d_image,  d_image_name,
    								created, main_new, main_special, main_best,
    							option1_chk, option2_chk, option3_chk, option4_chk, option5_chk,
    							del_chk, approved)
			    		VALUES('$prod_code', '$lcode', '$mcode',
					  		 		'$name', '$short_desc', '$company', '$importer', '$id', '$retail_price',
				      		 		'$moq',  '$opt', '$opt_stock', '$stock',
					  		 		'$simg_chk',   '$file1',
					   		 		'$bimg1_chk', '$file3',
							 		'$bimg2_chk', '$file4',
							 		'$bimg3_chk', '$file5',
							 		'$bimg4_chk', '$file6',
							 		'$bimg5_chk', '$file7',
							 		'$dimg_chk',  '$file8',
							 		now(), '$main_new', '$main_special', '$main_best',
									'$option1_chk', '$option2_chk', '$option3_chk', '$option4_chk', '$option5_chk',
									'$del_chk', '$approved')";

    $result = mysqli_query($connect, $sql);
    mysqli_query($connect, 'set names utf8');

    if ($result) {
        echo "Line " . $line . " : <" . $company . "> " . $prod_code . " -> inserted done! \n";
    } else {
        echo "DB 오류발생";
    }

    $line++;
}

fclose($fp);
