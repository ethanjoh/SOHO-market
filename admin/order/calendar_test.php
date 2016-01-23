<?/////연도달력?>
<html>
<head>
<style>
body
{scrollbar-face-color: #ffffff;
scrollbar-highlight-color: #336699;
scrollbar-3dlight-color: #ffffff;
scrollbar-shadow-color: #336699;
scrollbar-darkshadow-color: #ffffff;
scrollbar-track-color: #ffffff;
scrollbar-arrow-color: #336699}

body, td, select, input, div, form, textarea, center, option, pre, blockquote{font-size:9pt; font-family:Verdana; color:#666666;}

A:link    {color:#336699;text-decoration:none;}
A:visited {color:#336699;text-decoration:none;}
A:active  {color:#336699;text-decoration:none;}
A:hover   {color:#c0c0c0;text-decoration:none;}
</style></head>
<!--
Y : 네자리 연도, 예) 1999
y : 두자리 연도, 예) 99
z : 해당 연도의 날짜수, 0부터 366까지
m : 월 숫자, 01부터 12까지
n : 월 숫자, 0이 붙지 않음. 1부터 12까지
F : 월 이름, 문자열. January, Febrary 등
t : 주어진 월의 일수 혹은 주어진 달의 마지막 일, 28부터 31까지
d : 일(day), 앞에 0이 붙은 2자리 숫자, 01부터 31까지
j : 앞에 0이 없는 일, 1부터 31까지(d 참고)
D : 요일 이름, 3글자의 영문자. Sun, Mon 등
w : 요일 숫자, 0(일요일) 부터 6(토요일)
-->
<body>
<?
if(!$y) $y = date("Y"); //연도 입력이 없는 경우 올해로
$p_y = $y - 1; //이전해
$n_y = $y + 1; //다음해
$t_m = date("n"); //지금이 몇월인가
$t_y = date("Y"); //지금이 몇년도인가
?>
<table width="640" align="center" style="border-width:1; border-color:#336699; border-style:dashed;">
<tr>
<td width="100" align="left">   <b><font style="font-size:8pt"><a href="<?=$php_self?>?y=<?=$p_y?>"><?=$p_y?>년</a& gt;</font></b></td>
<td width="440" align="center"><b><font color="ff6633"><?=$y?>년</font></b></td>
<td width="100" align="right"><b><font style="font-size:8pt"><a href="<?=$php_self?>?y=<?=$n_y?>"><?=$n_y?>년</a& gt;</font></b>   </td>
</tr>
</table>

<table  width="640" align="center" cellpadding="0" cellspacing="0">
<tr><td colspan="5" height="20"></td></tr>
<tr>
<?
for($i=1;$i<=12;$i++) {
        $l_d = date("t",mktime(0,0,0,$i,1,$y)); //각 월의 마지막 날
        $start = date("w",mktime(0,0,0,$i,1,$y)); //각 월의 1일이 무슨요일인가
        $last = date("w",mktime(0,0,0,$i,$l_d,$y)); //각 월의 마지막 날이 무슨요일인가
        $f = date("F",mktime(0,0,0,$i,1,$y)); //영어로 된 달이름
        if($i == $t_m and $y == $t_y) {
                $m = "<b>$f</b>"; // 이번달은 두꺼운 글자로 처리
        } else {
                $m = "$f";
        }
?>
<td>

<table width="200" height="130" style="border-width:1; border-color:#336699; border-style:dashed;">
<tr><td colspan="7" align="center"><font color="#336699"><?=$m?></font></td></tr>
<tr>
<?
        if($start != 0) { //1일이 일요일이 아닐경우 밀리는 만큼 <td></td> 반복
                for($r_s=1;$r_s<=$start;$r_s++) {
?>
<td> </td>
<?
                }
        }
        for($j=1;$j<=$l_d;$j++) { //각 월별로 일자 반복
                $d_k = date("w",mktime(0,0,0,$i,$j,$y));
                if($d_k == "0") { // 일요일일 경우 주황색으로
?>
<td align="center"><font color="#ff6633"><?=$j?></font></td>
<?
                } elseif($d_k == "6") { //토요일일 경우 녹색으로, <tr> 삽입
?>
<td align="center"><font color="#339933"><?=$j?></font></td></tr><tr>
<?
                 } else {
?>
<td align="center"><?=$j?></td>
<?
                }
        }
        if($last != 6) { //말일이 토요일이 아닐경우 남는 만큼 <td></td> 반복
                for($k=1; $k<=6-$last;$k++) {
?>
<td> </td>
<?
                }
        }
?>
</tr></table>

<?
        if($i == 3 or $i == 6 or $i == 9) { //3월, 9월, 6월일 경우 <tr>삽입
?>
</td></tr><tr><td colspan="5" height="20"></td></tr><tr>
<?
        } elseif($i == 12) { //12월일 경우
?>
</td>
<?
        } else { // 다른 달일 경우 달력 테이블 끝난 후 공백 삽입
?>
        </td><td width="20"> </td>
<?
        }
}
?>
</tr></table>
