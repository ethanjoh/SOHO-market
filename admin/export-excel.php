<?php

include_once "include/admin_auth.php";
include_once "../util/util.php";
include_once "Classes/PHPExcel.php";

$sql    = "SELECT * FROM products ORDER BY num";
$result = mysqli_query($connect, $sql);

// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set properties
$objPHPExcel->getProperties()->setCreator("마켓")
    ->setLastModifiedBy("마켓")
    ->setTitle("소호마켓 제품목록")
    ->setSubject("소호마켓 제품목록")
    ->setDescription("소호마켓 제품목록")
    ->setKeywords("제품목록")
    ->setCategory("제품");

// Add some data
$objPHPExcel->setActiveSheetIndex(0)
    ->setCellValue("A1", "#")
    ->setCellValue("B1", "제품명")
    ->setCellValue("C1", "제품가")
    ->setCellValue("D1", "공급가")
    ->setCellValue("E1", "옵션")
    ->setCellValue("F1", "옵션별 재고")
    ->setCellValue("G1", "옵션 품절여부(1: 판매, 0: 품절. -1: 단종)")
    ->setCellValue("H1", "판매 여부(N: 판매, Y: 판매중지. O: 일시품절, C:단종)");

//  Set width
$objPHPExcel->getActiveSheet()->getColumnDimension('C')
    ->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('D')
    ->setWidth(15);
$objPHPExcel->getActiveSheet()->getColumnDimension('E')
    ->setWidth(70);
$objPHPExcel->getActiveSheet()->getColumnDimension('F')
    ->setWidth(50);
$objPHPExcel->getActiveSheet()->getColumnDimension('G')
    ->setWidth(100)
$objPHPExcel->getActiveSheet()->getColumnDimension('H')
    ->setWidth(15);

if (mysqli_num_rows($result)) {

    for ($i = 2; $row = mysqli_fetch_array($result); $i++) {
        // Add some data
        $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValue("A" . $i, "$row[num]")
            ->setCellValue("B" . $i, "$row[name]")
            ->setCellValue("C" . $i, "$row[shop_price]")
            ->setCellValue("D" . $i, "$row[retail_price]")
            ->setCellValue("E" . $i, "$row[opt]")
            ->setCellValue("F" . $i, "$row[opt_count]")
            ->setCellValue("G" . $i, "$row[opt_stock]")
            ->setCellValue("H" . $i, "$row[del_chk]");

        $objPHPExcel->getActiveSheet()->getStyle("B" . $i)
            ->getAlignment()
            ->setWrapText(true);
    }

} else {

    $objPHPExcel->getActiveSheet()->mergeCells('A2:H2');
    $objPHPExcel->getActiveSheet()
        ->getCell('A2')
        ->setValue('No data');
    $objPHPExcel->getActiveSheet()
        ->getStyle('A2')
        ->getAlignment()
        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
}

// Rename sheet
$objPHPExcel->getActiveSheet()->setTitle("소호마켓 제품목록");

// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);

// 파일의 저장형식이 utf-8일 경우 한글파일 이름은 깨지므로 euc-kr로 변환해준다.
$filename = iconv("UTF-8", "EUC-KR", "소호마켓 제품목록") . "-" . date("Y-m-d");

// Redirect output to a client’s web browser (Excel2007)
// header('Content-Type: application/vnd.ms-excel');
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $filename . '.xlsx"');
header('Cache-Control: max-age=0');

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');

exit;
