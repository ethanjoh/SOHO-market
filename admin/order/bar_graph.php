<?php
function bar_graph($val,$x,$y,$x_val,$img_url,$legend,$theme)   { //-- 막대 그래프 만들어주는 함수
     /*
     $val : 값을 원소로 하는 배열
     $x : 그래프 가로축 크기
     $y : 그래프 세로축 크기
     $x_val : x축 값의 이름 배열
     $img_url : 저장할 파일의 경로와 이름(png)
     */
    
     $gaesu = count($val);   //-- 그래프 막대 갯수
     $makde_pok = ($x / $gaesu) / 3;   //-- 막대 하나 폭
     $real_y = $y - 40;    //-- 그래프가 그려질 실제 위치
    
     $max_value = $val[0];
     for ($i=0;$i<$gaesu;$i++)     {
         if($val[$i] > $max_value)   $max_value = $val[$i];
         }

     $im =  @ImageCreate($x,$y) or die ("이미지를 초기화 하지 못했습니다");
	  
	  switch($theme) {
	  	case "red" :
	  		$backgroundcolor=ImageColorAllocate($im,208,208,208);  //-- 그래프 바탕색
     		$rectanglecolor = ImageColorAllocate($im,198,34,34); //-- 그래프 색깔
     		$white=ImageColorAllocate($im,255,255,240);            //-- 그래프 바닥색
     		$color_x = imagecolorallocate($im, 0, 0, 0); //x 값, (black)
	  		$color_y = imagecolorallocate($im, 255, 233, 53); // y 값 (white) 
	  		$legend_color = imagecolorallocate($im, 255, 0, 0); // 그래프 제목 
	  		break;
	  	case "green" :
	  		$backgroundcolor=ImageColorAllocate($im,208,208,208);  
     		$rectanglecolor = ImageColorAllocate($im,46,87,30); 
     		$white=ImageColorAllocate($im,255,255,240);            
     		$color_x = imagecolorallocate($im, 0, 0, 0); 
	  		$color_y = imagecolorallocate($im, 255, 233, 53); 
	  		$legend_color = imagecolorallocate($im, 255, 0, 0);
	  		break;   	
	  	case "blue" :
	  		$backgroundcolor=ImageColorAllocate($im,208,208,208);  
     		$rectanglecolor = ImageColorAllocate($im,65,127,250); 
     		$white=ImageColorAllocate($im,255,255,240);            
     		$color_x = imagecolorallocate($im, 0, 0, 0); 
	  		$color_y = imagecolorallocate($im, 255, 233, 53);  
	  		$legend_color = imagecolorallocate($im, 255, 0, 0);
	  		break;  	  	
	  	default :
	  		$backgroundcolor=ImageColorAllocate($im,208,208,208);
     		$rectanglecolor = ImageColorAllocate($im,65,127,250); 
     		$white=ImageColorAllocate($im,255,255,240);            
     		$color_x = imagecolorallocate($im, 0, 0, 0); 
	  		$color_y = imagecolorallocate($im, 255, 233, 53); 
	  		$legend_color = imagecolorallocate($im, 255, 0, 0);
	  		break;   	
	  }

     ImageFilledRectAngle($im,0,$real_y,$x,$y,$white);    
     for ($i=0;$i<$gaesu;$i++)   {
           ($i == 0) ? $makde_x[$i] = $makde_pok: $makde_x[$i] = ($makde_x[$i - 1] + $makde_pok * 3);
           $makde_y[$i] = $real_y - ($val[$i]/$max_value) * $real_y; //-- 각각의 막대 y 좌표

           ImageFilledRectAngle($im,$makde_x[$i],$makde_y[$i],$makde_x[$i]+$makde_pok,$real_y,$rectanglecolor);          
           ($makde_y[$i] < 0) ? $y_string = 0 : $y_string = $makde_y[$i]+10;
			  ImageTTFtext($im,8,0,$makde_x[$i],$y_string,$color_y, "nanum.ttf", $val[$i]); //Y축 값
           ImageTTFtext($im,8,90,$makde_x[$i]-2,$y-40,$color_x, "nanum.ttf", $x_val[$i]); //X축 값 ImageTTFtext (이미지 구분자, 크기, 각도, X좌표, Y좌표, 색 구분자, TTF파일, 문자열);       
     }
     ImageTTFtext($im,8,0,10,$y-10,$legend_color, "nanum.ttf", $legend); //타이틀 (이미지 구분자, 크기, 각도, X좌표, Y좌표, 색 구분자, TTF파일, 문자열);
     
     ImagePNG($im,$img_url);
     ImageDestroy($im);
     
     echo "<img src=\"$img_url\" border=\"0\" />";
    
}

$data = array();
$x_index = array();

$data[0] = 10;
$data[1] = 50;
$data[2] = 30;
$data[3] = 90;
$data[4] = 100;

$x_index[0] = "사과";
$x_index[1] = "배";
$x_index[2] = "귤";
$x_index[3] = "오렌지";
$x_index[4] = "바나나";

$width = 400;
$height = 300;
$img = "graph.png";
$title = "[판매 수량 그래프]";
$theme = "blue"; //red, blue, green 중 하나

bar_graph($data,$width,$height,$x_index,$img,$title,$theme);

echo "<p>";
$img = "graph1.png";
$theme = "red"; //red, blue, green 중 하나
bar_graph($data,$width,$height,$x_index,$img,$title,$theme);
echo "</p>";
?>
