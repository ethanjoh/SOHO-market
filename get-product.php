<?php
/**
 * 상품정보 업로드하기
 * get-product.php?f=[csv 파일명(확장자 제외)]
 * csv 파일은 /upload 폴더에 위치
 * 원본상품 이미지는 /img 폴더에 위치
 *
 * data[0]:번호, data[1]: 상품코드, data[2]: 상품명, data[3]: 공급가, data[4]:이미지, data[5]: 서브분류,
 * data[6]: 모델번호, data[7]: 브랜드, data[8]: 규격, data[9]: 소비자가
 * 반드시 카테고리에 따른 lcode와 mcode  확인하고 변경 후 실행할 것
 */

include_once "util/util.php";

/**
 * csv 파일  가격에서 ',' 제거
 * @param  [type] $price          [description]
 * @return [type] [description]
 */
function removeComma($price)
{
    if (preg_match("/^[0-9,]+$/", $price)) {
        $price = str_replace(',', '', $price);
    }

    return $price;
}

if (isset($_GET)) {
    $filename = $_GET['f'];
} else {
    echo "no specified file";
    exit;
}

$csvFilePath = "upload/" . $filename . ".csv";

// 테이블을 비우고 입력하고 싶을 때
// mysqli_query($connect, "TRUNCATE TABLE products");

$tempCSV = file_get_contents($csvFilePath);
$tempCSV = mb_convert_encoding($tempCSV, 'UTF-8', 'EUC-KR');

$fp = tmpfile();
fwrite($fp, $tempCSV);
rewind($fp);
setlocale(LC_ALL, 'ko_KR.UTF-8');

$line = 1;

while ($data = fgetcsv($fp)) {

    // echo "<pre>";
    // print_r($data);
    // echo "</pre>";

    $lcode          = "1";                           // 대카테고리
    $itemCode       = trim($data['1']);              // 상품코드
    $shortDesc      = trim($data['8']);              // 규격=>간략설명
    $wholesalePrice = removeComma(trim($data['3'])); // 공급가. 기존 소비자가 컬럼에 삽입
    $shopPrice      = removeComma(trim($data['9'])); // 소비자판매가
    $name           = addslashes(trim($data['6']));  // 모델번호 =>상품명
    $brand          = trim($data['7']);              // 브랜드
    $id             = "admin";
    $importer       = "신수상사";

    //DB에 저장할 이미지 저장 경로
    $saveDir = "../../upload/p_image/";

    // 서브분류에 따라 저장
    // 대표이미지 생성 후 썸네일 이미지 자동생성
    if (trim($data['5']) == '아이언/우드그립' || trim($data['5']) == '클럽그립' || trim($data['5']) == '주니어 그립') {
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "1"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/iron/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/iron-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '퍼터그립') {
        // 이미지 파일이 있는 경우
        if (($data['4']) != '') {
            $mcode       = "2";
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/putter/" . $data['4'], $bigImg1Path . $data['4']);

            //썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);
            // 썸네일 생성 끝

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/putter-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '공구류') {
        // fitting tools
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "21"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/tools/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/tools-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '370' || trim($data['5']) == '350' || trim($data['5']) == '335' || trim($data['5']) == '') {
        // ferrule iron, wood, sp
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "20"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/ferrule/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/ferrule-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '벤딩샤프트') {
        // 샤프트
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "22"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/shaft/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/shaft-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '경량스틸샤프트') {
        // 샤프트
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "23"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/shaft/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/shaft-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '수리용샤프트') {
        // 샤프트
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "24"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/shaft/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/shaft-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } elseif (trim($data['5']) == '스틸샤프트') {
        // 샤프트
        // 이미지 파일이 있는 경우
        if ($data['4'] != '') {
            $mcode       = "25"; // 중카테고리
            $bImg1_chk   = "Y";
            $bigImg1File = $saveDir . $data['6'] . "/b/" . $data['4'];

            // 1) 생성할 디렉토리명은 모델번호로 지정
            $bigImg1Path = "upload/p_image/" . $data['6'] . "/b/";
            if (is_dir($bigImg1Path)) {
                echo "<p>directory " . $bigImg1Path . " is already exists.</p>\n";
            } else {
                if (mkdir($bigImg1Path, 0755, true)) {
                    echo "<p>directory " . $bigImg1Path . " is created successfully. </p>\n";
                } else {
                    echo "<p>directory " . $bigImg1Path . " is failed to create.</p>\n";
                }
            }

            copy("img/shaft/" . $data['4'], $bigImg1Path . $data['4']);

            // 2) 썸네일 자동생성
            $smallImg1Path = "upload/p_image/" . $data['6'] . "/s/";

            if (is_dir($smallImg1Path)) {
                echo "<p>directory " . $smallImg1Path . " is already exists. </p>\n";
            } else {
                if (mkdir($smallImg1Path, 0755, true)) {
                    echo "<p>directory " . $smallImg1Path . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $smallImg1Path . " is failed to create.</p>\n";
                }
            }
            $simg1_chk     = "Y";
            $smallImg1File = $saveDir . $data['6'] . "/s/" . $data['4'];
            make_thumbnail($bigImg1Path . $data['4'], 100, 100, $smallImg1Path . $data['4']);

            // 3) 상세 이미지 복사
            $detailImgFile = '<img src="../upload/p_image/' . $data['6'] . "/d/" . $data['4'] . '">';
            $detailImgFile = addslashes($detailImgFile);

            $detailImgFilePath = "upload/p_image/" . $data['6'] . "/d/";
            if (is_dir($detailImgFilePath)) {
                echo "<p>directory " . $detailImgFilePath . " is already exists. </p>\n";
            } else {
                if (mkdir($detailImgFilePath, 0755, true)) {
                    echo "<p>directory " . $detailImgFilePath . " is created successfully.</p>\n";
                } else {
                    echo "<p>directory " . $detailImgFilePath . " is failed to create.</p>\n";
                }
            }
            copy("img/shaft-detail/" . $data['4'], $detailImgFilePath . $data['4']);
        } else {
            $bigImg1File   = 'http://placehold.it/500x500';
            $smallImg1File = 'http://placehold.it/100x100';
            $detailImgFile = '';
        }

    } else {
        $bImg1_chk   = "N";
        $bigImg1File = "";
    }

    // 재고
    $stock   = "999";
    $del_chk = "N";

    //content
    // $contents = htmlspecialchars($data['16'], ENT_QUOTES);

    //메인표시 플래그
    $main_new     = "N";
    $main_special = "N";
    $main_best    = "N";

    $option1_chk = "N";
    $option2_chk = "N";
    $option3_chk = "N";
    $option4_chk = "N";
    $option5_chk = "N";

    // 상품명=>옵션
    $opt       = trim($data['2']);
    $opt_stock = '1';

    $event = "0";

    // 상품승인 플래그
    $approved = "Y";

    $moq = "1";

    $sql = "INSERT INTO products(prod_code, category_l, category_m,
								name, short_desc, company, importer, id, shop_price, retail_price,
								moq, opt, opt_stock,stock,contents,
    							s_image1, s_image1_name,
    							b_image1, b_image1_name,
    							created, main_new, main_special, main_best,
    							option1_chk, option2_chk, option3_chk, option4_chk, option5_chk,
    							del_chk, approved)
			    		VALUES('$itemCode', '$lcode', '$mcode',
					  		 		'$name', '$shortDesc', '$brand', '$importer', '$id', '$shopPrice', '$wholesalePrice',
				      		 		'$moq',  '$opt', '$opt_stock', '$stock', '$detailImgFile',
					  		 		'$simg1_chk',   '$smallImg1File',
					   		 		'$bImg1_chk', '$bigImg1File',
							 		now(), '$main_new', '$main_special', '$main_best',
									'$option1_chk', '$option2_chk', '$option3_chk', '$option4_chk', '$option5_chk',
									'$del_chk', '$approved')";

    $result = mysqli_query($connect, $sql);
    mysqli_query($connect, 'set names utf8');

    if ($result) {
        echo "Line " . $line . " : <" . $brand . "> " . $itemCode . " -> inserted done! \n";
    } else {
        echo "DB 오류발생";
    }

    $line++;
}

fclose($fp);
