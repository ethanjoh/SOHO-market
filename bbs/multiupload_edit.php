<?
	include "db_connect.php";

	$main_no = $_GET[main_no]; 
	
   //Restore data from DB
	$sql = "SELECT * FROM board  WHERE main_no=$main_no ";
	$result = mysqli_query($connect, $sql);
	$row = mysqli_fetch_array($result);
	
	$uploadset = 0; //hidden으로 넘길 기존 첨부파일 갯수
	
	$max_file_num = 3; //업로드할 파일 갯수 지정
	
	//기존 첨부파일 여부 체크	
	for($i=0; $i < $max_file_num; $i++)
	{
		if(strlen($row[filename.$i]) > 0)
		{
			//$path = $row[filename.$i];					

			//Array 값으로 분리, [0]에는 "_"이전 값이, [1]에는 "_"이후 값이 들어있다.
			$chk_name = explode("_", $row[filename.$i]); 
			$old_file[$i] = $chk_name[sizeof($chk_name)-1];
		}
	}	
?>
	
<html>
<head>
<meta HTTP-EQUIV="CONTENT-TYPE" content="text/html;charset=UTF-8">
<title>글 수정하기</title>
<link href="default.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
    function send()
    {
		  if (document.edit_form.passwd.value.length <1) {
                alert("비밀번호를 입력하십시오.");
                document.edit_form.passwd.focus();
                return false;
        }
	 document.edit_form.submit();
    }
-->
</script>
</head>

<body bgcolor=#ffffff>
<div align="center">
<!------------------------ 게시판 제목 --------------------------->
<table border="0" width="80%">
<tr>
    <td class="plain" align="center">수정하기</td>
</tr>
</table>
<p></p>

<form name="edit_form" action="edit_ok_test.php" ENCTYPE="multipart/form-data" method="post">
<input type="hidden" name="main_no" value="<? echo $main_no ?>">
<input type="hidden" name="old_file[]" value="<? echo $old_file ?>">
<table cellspacing="0" border="0">
<tr>
    <td align="left" width="70">글쓴이 </td>
    <td align="left"><? echo $row[name] ?></td>
</tr>
<tr>
    <td align="left">패스워드</td>
    <td align="left"><input type="password" name="passwd" size="12" maxlength="12"></td>
</tr>   
<tr>
    <td align="left">이메일</td>
    <td align="left"><input type="text" name="email" size="30" maxlength="30" value="<? echo $row[email] ?>"></td>
</tr>   
<tr>
    <td align="left" valign="middle">제 목 </td>
    <td align="left"><input type="text" name="title" size="50" maxlength="50" value="<? echo $row[title] ?>"></td>
</tr>
<tr>
    <td align="center" colspan="2"><textarea name="content" rows="17" cols="75"><? echo $row[content] ?></textarea><br></td>
</tr>
</table>

<?
	//////////////기존 첨부파일 표시 및 파일 첨부하기////////////////////////////	
	$max_file_num = 3; //업로드할 파일 갯수 지정
	
	
	echo "<table width=\"80%\">\n";
	
	for($i=0; $i < $max_file_num; $i++)
	{
		if(strlen($real_name[$i]) > 0)
		{
			$path = $real_name[$i];					

			//Array 값으로 분리, [0]에는 "_"이전 값이, [1]에는 "_"이후 값이 들어있다.
			$chk_name = explode("_", $real_name[$i]); 
			$file_name = $chk_name[sizeof($chk_name)-1];
										
			//체크된 값만 chk_delete 배열에 순서대로 저장된다.					
			echo "<tr><td width=\"120\" align=\"left\">파일 첨부 (1M 이하)
      			<input type=\"file\" name=\"uploadedfile[]\" size=\"30\">&nbsp;
      			<img src=\"paperclip-16x16.png\"><a href=\"$path\">$file_name</a>
      			<input type=\"checkbox\" name=\"chk_delete[]\" value=\"${row["filename".$i]}\">삭제 </td></tr>\n";    			
 	 	}
	 	else
	 	{
			echo "<tr><td width=\"120\" align=\"left\">파일 첨부 (1M 이하)
      			<input type=\"file\" name=\"newupload[]\" size=\"30\"></td></tr>\n";
      }
	}
	
	echo "</table>\n";
	//////////////파일 첨부하기////////////////////////////
?>
<!------------------ 게시판 기능 버튼 ------------------------------>
<table width="80%">
<tr>
	<td colspan="2" align="center">
		<input type="button" onClick="send()" value="수 정">
		<input type="button" onClick="javascript:(document.location.replace('read.php?main_no=<? echo $main_no ?>'));" value="취 소">
		<input type="button" onClick="javascript:(document.location.replace('list.php'));" value="글 목록보기"></td>
</tr>
<tr><td colspan="2"  height="1" bgcolor="#F0F0F0"></td></tr>
</table>
<!------------------ 게시판 기능 버튼 ------------------------------>
</form>
</div>
</body>
</html>
