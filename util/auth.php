<?php

if(!isset($_COOKIE['ROOT_ID']) && !isset($_COOKIE['ROOT_PASS'])) {
//if(!isset($_SESSION['p_id']) && !isset($_SESSION['p_pw'])) {
		echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
				<script>
					window.alert('로그인 하시기 바랍니다.');
					history.go(-1);
            	</script>";
	exit;
}
?>