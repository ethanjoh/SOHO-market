<?
include	"../include/admin_top.php";

$mode = set_var($_POST['mode']);
$p_num = set_var($_POST['p_num']);
$page = set_var($_POST['page']);

if($s_image_name){
  $file_ext1 = substr(strrchr($s_image_name,"."), 1);
  $file_ext1 = strtolower($file_ext1);
  if ($file_ext1 != 'jpg' && $file_ext1 != 'gif' && $file_ext1 != 'jpeg' && $file_ext1 != 'png'  ){
	 err_msg("이미지 파일만 올릴 수 있습니다.");  
  }
  if (!$s_image_size) {
	 err_msg("지정한 파일이 없거나 파일 크기가 0KB입니다.");  
  }   
}

if($m_image_name){
  $file_ext2 = substr(strrchr($m_image_name,"."), 1);
  $file_ext2 = strtolower($file_ext2);
  if ($file_ext2 != 'jpg' && $file_ext2 != 'gif' && $file_ext2 != 'jpeg' && $file_ext2 != 'png' )  {
	 err_msg("이미지 파일만 올릴 수 있습니다.");  
  }
  if (!$m_image_size) { 
	 err_msg("지정한 파일이 없거나 파일 크기가 0KB입니다.");  
  }   
}

if($b_image_name){
  $file_ext3 = substr(strrchr($b_image_name,"."), 1);
  $file_ext3 = strtolower($file_ext3);  
  if ($file_ext3 != 'jpg' && $file_ext3 != 'gif' && $file_ext3 != 'jpeg' && $file_ext3 != 'png' )  {
	 err_msg("이미지 파일만 올릴 수 있습니다.");  
  }
  if (!$b_image_size) { 
	 err_msg("지정한 파일이 없거나 파일 크기가 0KB입니다.");  
  }   
}

if($mode =='insert'){
  
  $query = "insert into products_code values ('')";
  mysqli_query($connect, $query);

  $query = "select max(num) as maxid from products_code";
  $result = mysqli_query($connect, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
  $p_code = $row[maxid];
  
  $wdate = date('md');
  $trade_code ="p".$wdate."-".$p_code;

  $savedir ="../upload/p_image";

  if($s_image_name){
   $temp1 = $trade_code.".".$file_ext1;
   copy($s_image, "$savedir/s/$temp1");
   unlink($s_image);
   $simg_chk = "Y";
  }
  else{
   $simg_chk = "N";
  }

  if($m_image_name){
   $temp2 = $trade_code.".".$file_ext2;
   copy($m_image, "$savedir/m/$temp2");
   unlink($m_image);
   $mimg_chk = "Y";
  }
  else{
   $mimg_chk = "N";
  }

  if($b_image_name){
   $temp3 = $trade_code.".".$file_ext3;
   copy($b_image, "$savedir/b/$temp3");
   unlink($b_image);
   $bimg_chk = "Y";
  }
  else{
   $bimg_chk = "N";
  }
    
   $name = addslashes($name);
   $company = addslashes($company);
   $size = addslashes($size);
   $contents = addslashes($contents);
   
   if($con_html=='2'){
     $contents = htmlspecialchars($contents);
     $contents = chop($contents);
   }

   if(!$option1_chk){
     $option1_chk = "N";
   }

   if(!$option2_chk){
     $option2_chk = "N";
   }

   $dbinsert1 = "insert into products(prod_code,category_l,
                  category_m,name,company,cust_price,price,
	              mileage,size,con_html,contents,s_image,s_image_ty,
                  m_image,m_image_ty,b_image,b_image_ty,
				  created,option1_chk,option2_chk,del_chk)
			    values('$trade_code','$up_category','$category_m',
					   '$name','$company','$cust_price','$price',
				       '$mileage','$size','$con_html','$contents',
					   '$simg_chk','$file_ext1','$mimg_chk','$file_ext2',
					   '$bimg_chk','$file_ext3',now(),
				       '$option1_chk','$option2_chk','$del_chk')";
   $result1 = mysqli_query($connect, $dbinsert1);
  
   if($result1){    
	  echo("
       <script>
	    window.alert('상품을 등록했습니다.')
	   </script>
	  ");
      echo "<meta http-equiv='Refresh' content='0; URL=pro_list.php?level=$level&page=$page&up_category=$up_category&category_m=$category_m'>"; 
    }
   else{
	 err_msg('DB오류가 발생했습니다.');
   }
 }
 else if($mode =='update'){

  $query = "select * from products where num=$p_num";
  $result = mysqli_query($connect, $query);
  $row = mysqli_fetch_array($result);
  mysqli_free_result($result);
      
  $savedir ="../upload/p_image";
  $temp1 = $row[prod_code].".".$file_ext1;
  $temp2 = $row[prod_code].".".$file_ext2;
  $temp3 = $row[prod_code].".".$file_ext3;

  if($s_image_name){
    copy($s_image, "$savedir/s/$temp1");
    unlink($s_image);
    $temp1_char = ", s_image='Y' , s_image_ty='$file_ext1' ";
  }

  if($m_image_name){
    copy($m_image, "$savedir/m/$temp2");
    unlink($m_image);
    $temp2_char = ", m_image='Y' , m_image_ty='$file_ext2' ";
  }

  if($b_image_name){
    copy($b_image, "$savedir/b/$temp3");
    unlink($b_image);
    $temp3_char = ", b_image='Y' , b_image_ty='$file_ext3' ";
  }

  $name = addslashes($name);
  $company = addslashes($company);
  $size = addslashes($size);
  $contents = addslashes($contents);
  if($con_html=='2'){
     $contents = htmlspecialchars($contents);
     $contents = chop($contents);
  }

  if(!$option1_chk){
     $option1_chk = "N";
   }

   if(!$option2_chk){
     $option2_chk = "N";
   }

   $dbinsert1 = "update products set category_l='$up_category',
                                     category_m='$category_m',
                                     name='$name',
									 company='$company',
									 cust_price='$cust_price',
									 price='$price',
									 mileage='$mileage',
				                     size='$size',
                                     con_html='$con_html',
									 contents='$contents' 
									 $temp1_char 
									 $temp2_char 
									 $temp3_char ,
				                     option1_chk='$option1_chk',
									 option2_chk='$option2_chk',
									 del_chk='$del_chk' 
				  where num=$p_num ";
	$result1 = mysqli_query($connect, $dbinsert1);
  
    if($result1) {    	 
     echo("
       <script>
	    window.alert('상품 등록정보를 수정했습니다.')
	   </script>
	  ");
      echo "<meta http-equiv='Refresh' content='0; URL=pro_list.php?level=$level&page=$page&up_category=$up_category&category_m=$category_m'>"; 
    }
    else{
     err_msg('DB오류가 발생했습니다.');
    }
 }
?>
