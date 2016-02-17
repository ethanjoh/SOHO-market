<?php

include_once "../include/admin_auth.php";
include_once "../../util/config.php";
include_once "../../util/util.php";

$connect = my_connect($host, $dbid, $dbpass, $dbname);

if ($mode == "cancel") {
    // 해당 발행정보를 취소처리 합니다.
    $update = "UPDATE tax_list SET cancel='Y' WHERE num='$num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
					<script>
						alert('취소처리했습니다.')
					</script>
					<meta http-equiv='Refresh' content='0; URL=monthly_stat_list.php'>";
    } else {
        echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
					<script>
						alert('취소처리에 실패했습니다.')
					</script>
					<meta http-equiv='Refresh' content='0; URL=monthly_stat_list.php'>";
    }
} else if ($mode == "del") {

    $update = "DELETE FROM tax_list WHERE num='$num' ";
    $result = mysqli_query($connect, $update);

    if ($result) {
        echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
					<script>
						alert('삭제하였습니다.')
					</script>
					<meta http-equiv='Refresh' content='0; URL=monthly_stat_list.php'>";
    } else {
        echo "<meta http-equiv='content-type' content='text/html; charset=UTF-8' />
					<script>
						alert('삭제처리에 실패했습니다.')
					</script>
					<meta http-equiv='Refresh' content='0; URL=monthly_stat_list.php'>";
    }
}
