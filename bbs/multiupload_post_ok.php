<?
    include "db_connect.php";

	//post.php에서 넘어온 값들을 변수에 저장한다.    
   $title = $_POST['title']; 
   $name = $_POST['name'];
   $content = $_POST['content'];
   $passwd = $_POST['passwd']; 	
   $email = $_POST['email'];
   
   $max_file_size  = 1024000;
   $uploaddir = 'upload/';
   
   //////////////////////파일 업로드 처리////////////////////////////
   if($_FILES['uploadedfile']) 
	{	
		//실제 업로드된 파일 수 확인
		$file_count = count($_FILES['uploadedfile']['name']);
		$count = $file_count;
		
		for($i=0; $i < $file_count; $i++)
		{
			if($_FILES['uploadedfile']['name'][$i] == "")
			{
				$count = $count -1;
			}
		}
		
		for($i=0; $i < $count; $i++)		
		{
       	// 중복되지 않는 파일로 만든다
			$filename[$i] = $uploaddir.substr(md5(uniqid($g4[server_time])),0,8)."_".$_FILES['uploadedfile']['name'][$i];   

			//파일 확장자 확인			
			$chk_file = explode(".", $_FILES['uploadedfile']['name'][$i]);
  			$extension = $chk_file[sizeof($chk_file)-1];
   						
			if($extension == "html" ||
      		$extension == "htm" ||
        		$extension == "php" || 
        		$extension == "asp" ||
        		$extension == "jsp" ||
        		$extension == "exe")
        	{
        		$errmsg = $_FILES['uploadedfile']['name'][$i]." 파일은 금지된 확장자입니다.";
        		exit;
        	}
        	
        	if($_FILES['uploadedfile']['size'][$i] > $max_file_size) //파일용량 확인 
			{
				$errmsg = $_FILES['uploadedfile']['name']." 파일 용량이 너무 큽니다.";
				exit;
			}
			
			if (file_exists($uploaddir.$_FILES['uploadedfile']['name'][$i]))
  			{
  				$errmsg = $_FILES['uploadedfile']['name'][$i]." 이(가) 이미 존재합니다.";
  				eixt;
  			}
 
			move_uploaded_file($_FILES['uploadedfile']['tmp_name'][$i],$filename[$i]);
			chmod("$filename[$i]",0777); // 파일에 권한 설정
				
			${"file".$i} = $filename[$i]; //변수명을 file0,1,2 식으로 바꾼다.
				
		} 
  	}

	//////////////////////파일 업로드 처리 끝///////////////////////////

	//게시판에서 제일 높은 게시물 번호를 구한다
	$query = "SELECT main_no FROM board ORDER BY main_no DESC LIMIT 1";
	$result = mysqli_query($connect, $query);
            
	//main_no는 자동증가하므로 공백 입력
	$sql = "INSERT INTO board ( main_no, 
															title, 
															name, 
															content, 
															passwd, 
															date, 
															count, 
															email, 
															filename0, 
															filename1, 
															filename2 )
           		VALUES ( '', 
           						'$title', 
           						'$name', 
           						'$content', 
           						'$passwd', 
           						now(), 
           						'0', 
           						'$email', 
           						'$file0', 
           						'$file1', 
           						'$file2')";

	//에러 메시지 처리	
	if($errmsg == "") 
	{   
   	mysqli_query($connect, $sql) or dbError(mysql_error());	
   	
   	echo "<script language=\"JavaScript\">
	          alert(\"글을 작성했습니다.\"); 
             document.location.replace(\"list.php\");
            </script>";
   } 
   else 
   {
   	echo "<script language=\"JavaScript\">
	          alert(\"$errmsg\"); 
             document.location.replace(\"list.php\");
            </script>";
    }   
?>

