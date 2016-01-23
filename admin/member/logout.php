<?
  // 세션사용을 위해 세션을 시작시킵니다.
  session_start();
  session_destroy();
  
  SetCookie("p_sid","", time(), '/');

  echo "<meta http-equiv='refresh' content='0; URL=../index.php'>";
?>