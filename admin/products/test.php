<!DOCTYPE html>
<html lang="ko">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<?php
    $optname_ins = "b,w,o,a";
    $opt = explode(",", $optname_ins);
    
	
    //echo count($opt);
    
    //옵션 갯수만큼 옵션재고관리 자동입력
	for($i=0;$i<count($opt);$i++) {
		if($i == 0)
			$opt_stock = "1";
		
		else $opt_stock .= ",1";	
	}
    
    
    echo $opt_stock;
    
    ?>
    
    
</body>
</html>
