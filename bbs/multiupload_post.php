<html>
<head>
<meta HTTP-EQUIV="CONTENT-TYPE" content="text/html;charset=UTF-8">
<title>글쓰기</title>
<link href="default.css" type="text/css" rel="stylesheet">
<script language="JavaScript">
<!--
    function send()
    {
        if (document.write_form.title.value.length <1) { 
            alert("제목을 입력하십시오.");
            document.write_form.title.focus();
            return false;
        } else if (document.write_form.content.value.length <1) {
                alert("본문 내용이 없습니다.");
                document.write_form.content.focus();
                return false;
        }
        document.write_form.submit();
    }
-->
</script>
</head>

<body bgcolor=#ffffff>
<div align="center">
<!------------------------ 게시판 제목 --------------------------->
<table border="0" width="80%">
<tr>
    <td class="plain" align="center">글쓰기</td>
</tr>
</table>
<p></p>
<!--<form name="write_form" action="post_ok.php" method="post">-->
<form name="write_form" method="post" ENCTYPE="multipart/form-data" action="post_ok.php">
<table cellspacing="0" border="0">
<tr>
    <td align="left" width="70">이 름</td>
    <td align="left">
        <input type="text" name="name" size="12" maxlength="12">
    </td>
</tr>
<tr>
    <td align="left">비밀번호</td>
    <td align="left">
        <input type="password" name="passwd" size="12" maxlength="12">
    </td>
</tr>   
<tr>
    <td align="left">이메일</td>
    <td align="left">
        <input type="text" name="email" size="30" maxlength="30">
    </td>
</tr>   
<tr>
    <td align="left" valign="middle">제 목</td>
    <td align="left">
        <input type="text" name="title" size="50" maxlength="50"></td>
</tr>
<tr>
    <td align="center" colspan="2">
        <textarea name="content" rows="17" cols="75"></textarea><br>
    </td>
</tr>
</table>

<!-- 파일첨부 -->
<table width="80%">
<?
	//////////////파일 첨부하기////////////////////////////	
	$max_file_num = 3; //업로드할 파일 갯수 지정
	
	echo "<table width=\"80%\">\n";
	
	for($i=0; $i < $max_file_num; $i++)
	{
		echo "<tr><td width=\"120\" align=\"center\">파일 첨부 (1M이하)
      			<input type=\"file\" name=\"uploadedfile[]\" size=\"30\">&nbsp;</td></tr>\n";
	}
	
	echo "</table>\n";
	//////////////파일 첨부하기////////////////////////////
?>
</table>

<!-- 글쓰기 버튼 -->
<table width="80%">
<tr><td height="1" bgcolor="#F0F0F0"></td></tr>
<tr>
	<td align="center">
		<input type="button" onClick="send()" value="입 력">
		<input type="reset" value="재작성">
		<input type="button" onClick="javascript:(document.location.replace('list.php'));" value="목록 보기">
	</td>
</tr>
<tr><td height="1" bgcolor="#F0F0F0"></td></tr>
</table>

</form>
</div>
</body>
</html>
