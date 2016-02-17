<?
   //include common functions to connect to DB
	include "db_connect.php";

   $main_no = $_POST['main_no'];
   $title = $_POST['title']; 
   $name = $_POST['name'];
   $content = $_POST['content'];
   $email = $_POST['email'];
   $passwd = $_POST['passwd'];

	//패스워드와 파일명을 가져온다.   	
	$pw_sql = "SELECT passwd, filename0, filename1, filename2 FROM board WHERE main_no=$main_no";
	$result = mysqli_query($connect, $pw_sql);
	$row = mysqli_fetch_array($result);

	//패스워드 확인	
	if($passwd != $row[passwd] )
	{
		echo "<script language=\"JavaScript\">
			     alert(\"패스워드가 맞지 않습니다.\");
              history.back(-1);
			 </script>";
			 exit;
	}
	else 
	{   
		///////////////삭제할 파일이 체크되어 있는지 확인///////////////////
		//삭제할 파일이 있다면, DB정보 업데이트 후 서버에서 삭제///////////	
		if(!empty($_POST['chk_delete']))
		{   
			echo "<pre>";
			print_r($_POST['chk_delete']);
	
			for($i=0; $i < count($_POST['chk_delete']); $i++)
			{			
				if($row[filename0] == $_POST['chk_delete'][$i])
				{ 	
						$sql = "UPDATE board SET filename0='' 
										WHERE main_no=$main_no";
						mysqli_query($connect, $sql) or dbError(mysql_error());
						unlink($_POST['chk_delete'][$i]);
				}
				elseif($row[filename1] == $_POST['chk_delete'][$i])
				{
						$sql = "UPDATE board SET filename1='' 
										WHERE main_no=$main_no";
						mysqli_query($connect, $sql) or dbError(mysql_error());
						unlink($_POST['chk_delete'][$i]);
				}
				elseif($row[filename2] == $_POST['chk_delete'][$i])
				{
						$sql = "UPDATE board SET filename2	='' 
										WHERE main_no=$main_no";
						mysqli_query($connect, $sql) or dbError(mysql_error());
						unlink($_POST['chk_delete'][$i]);
				}
   		}
   	}
		///////////////삭제할 파일이 체크되어 있는지 확인 끝 ///////////////////	
	}

   //////////////////////파일 업로드 처리////////////////////////////
   $max_file_size  = 1024000;
   $uploaddir = 'upload/';
   
   if(!empty($_FILES['uploadedfile'])) 
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

	///////////////////테이블 업데이트//////////////////////////////
	//에러 메시지 처리	
	if($errmsg == "") 
	{   
      $sql = "UPDATE board SET title='$title', 
		  													name='$name', 
															content='$content', 
															date=now(), 
															email='$email',
															filename0='$file0', 
															filename1='$file1', 
															filename2='$file2'															
	            								WHERE main_no=$main_no";

       mysqli_query($connect, $sql) or dbError(mysql_error());
   	
       echo "<script language=\"JavaScript\">
	              alert(\"글을 수정했습니다.\"); 
                 document.location.replace(\"read.php?main_no=".$main_no."\");
                  </script>";
   } 
   else 
   {
   	echo "<script language=\"JavaScript\">
	          alert(\"$errmsg\"); 
             document.location.replace(\"read.php?main_no=".$main_no."\");
            </script>";
    }     	   
    ///////////////////테이블 업데이트 끝//////////////////////////////		
  	}
	//////////////////////파일 업로드 처리 끝///////////////////////////

	
?>

