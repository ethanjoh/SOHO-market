<?
    include "db_connect.php";

	//filename을 받아 자료실 목록에서 검색하여 다운로드 시킴
	//다운되어 하드에 저장될 파일명의 추출
	$query = "SELECT file_name FROM board WHERE n_id = $n_id";
	$result = mysqli_query($connect, $query);
	
	//실제 저장되어 있는 파일의 추출
	$row = mysql_fetch_row($result);
	$real_file_name = $row[0];

	$query = "select file_id, save_dir,file_name from file_down where board_name = '$board_name' and n_id = $n_id";
	$result = mysqli_query($connect, $query);

	$row = mysql_fetch_row($result);
	$save_dir = $row[1]; // 저장 되어있는 경로명(상대경로)
	$file_name = $row[2]; //실제 저장되어 있는 파일명

	// 실제 소스는 여기부터입니다..

	$file = "/home/mak/board/$save_dir/$file_name"; //실제 파일명 또는 경로 (절대경로, 절대경로 입력을 몰라 1시간동안 헤맸습니다.)
	$dnurl = $real_file_name ; //다운받아 하드에 저장될때의 파일이름)
	//불필요하게 변수가 지정된 것은 게을러서 그냥 소스를 고쳐 사용하다 보니 ^^;;
	$dn = "0"; // 1 이면 다운로드, 0 이면 브라우져가 인식하면 화면에 출력
	$dn_yn = ($dn) ? "attachment" : "inline";

	$bin_txt = "1";
	$bin_txt = ($bin_txt) ? "r" : "rb";

	// attachment 면 바로 다운 inline 브라우져가 인식하면 화면에 출력
	if(eregi("(MSIE 5.5|MSIE 6.0)", $HTTP_USER_AGENT))
	{
		Header("Content-type: application/octet-stream");
		Header("Content-Length: ".filesize("$file")); // 이부분을 넣어 주어야지 다운로드 진행 상태가 표시 됩니다.
		Header("Content-Disposition: $dn_yn; filename=$dnfile");
		Header("Content-Transfer-Encoding: binary");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	} 
	else 
	{
		Header("Content-type: file/unknown");
		Header("Content-Length: ".filesize("$file"));
		Header("Content-Disposition: $dn_yn; filename=$dnurl");
		Header("Content-Description: PHP3 Generated Data");
		Header("Pragma: no-cache");
		Header("Expires: 0");
	}

	if (is_file($file))
	{
		$fp = fopen($file, $bin_txt);
		
		if (!fpassthru($fp)) // 서버부하를 줄이려면 print 나 echo 또는 while 문을 이용한 기타 보단 이방법이...
			fclose($fp);
		} 
		else 
		{
			echo "해당 파일이나 경로가 존재하지 않습니다.";
			exit;
		}
?> 