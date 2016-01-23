<?php

//$key:x축에 표시되는 배열값, $value:y축에 표시되는 배열값
function draw_graph($legend, $img_width, $img_height, $margins, $key, $value, $file_name) {
# —- Find the size of graph by substracting the size of borders
$graph_width=$img_width - $margins * 2;
$graph_height=$img_height - $margins * 2;
$img=imagecreate($img_width,$img_height);

$bar_width=20;
$total_bars=count($value);
$gap= ($graph_width- $total_bars * $bar_width ) / ($total_bars +1);

# ——- Define Colors —————-
$bar_color=imagecolorallocate($img,0,64,128);
$background_color=imagecolorallocate($img,240,240,255);
$border_color=imagecolorallocate($img,200,200,200);
$line_color=imagecolorallocate($img,220,220,220);
$yellow = imagecolorallocate($img, 255, 233, 53);
$black = imagecolorallocate($img, 0, 0, 0);

# —— Create the border around the graph ——
imagefilledrectangle($img,1,1,$img_width-2,$img_height-2,$border_color);
imagefilledrectangle($img,$margins,$margins,$img_width-1-$margins,$img_height-1-$margins,$background_color);
ImageTTFtext($img,8,0,10,($img_height-2)-5,$black, "nanum.ttf", $legend); //그래프 타이틀

# ——- Max value is required to adjust the scale ——-
$max_value=max($value);
$ratio= $graph_height/$max_value;

# ——– Create scale and draw horizontal lines ——–
$horizontal_lines=20;
$horizontal_gap=$graph_height/$horizontal_lines;

for($i=1;$i<=$horizontal_lines;$i++){
	$y=$img_height - $margins - $horizontal_gap * $i ;
	imageline($img,$margins,$y,$img_width-$margins,$y,$line_color);
	$v=intval($horizontal_gap * $i /$ratio);
	imagestring($img,0,5,$y-5,$v,$bar_color);
}

# ———– Draw the bars here ——
for($i=0;$i< $total_bars; $i++){
# —— Extract key and value pair from the current pointer position
	//list($key,$value)=each($values);
	$x1= $margins + $gap + $i * ($gap+$bar_width) ;
	$x2= $x1 + $bar_width;
	$y1=$margins +$graph_height- intval($value[$i] * $ratio) ;
	$y2=$img_height-$margins;
	$y_val = number_format($value[$i]);
	imagestring($img,0,$x1+3,$y1-10,$y_val,$bar_color); //각 막대그래프 상단에 그려지는 값
	//imagestring($img,0,$x1+3,$img_height-15,$key[$i],$bar_color);//x축값
	
	imagefilledrectangle($img,$x1,$y1,$x2,$y2,$bar_color);
	ImageTTFtext($img,6,90,$x1+8,$img_height-20,$yellow, "nanum.ttf", $key[$i]); //각 막대그래프의 x축 값
}

//header("Content-type:image/png");

imagepng($img, $file_name);
//$_REQUEST['asdfad']=234234;

imagedestroy($img);

// HTML code for the image
echo "<img src=\"$file_name\" border=\"0\" />";
}
?>