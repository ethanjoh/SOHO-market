<header class="header white-bg">
    <div class="sidebar-toggle-box">
        <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
    </div>
    <!--logo start-->
    <a href="/admin/main/main.php" class="logo"><img src="/images/shinsoo-logo.svg" class="admin-logo-top"></a>
    <!--logo end-->
    <div class="nav notify-row" id="top_menu">
        <!--  notification start -->
        <ul class="nav top-menu">
            <!-- settings start -->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-external-link"></i>
                </a>
                <ul class="dropdown-menu extended tasks-bar">
                    <div class="notify-arrow notify-arrow-green"></div>
                    <li>
                        <p class="green">바로가기</p>
                    </li>
                    <li class="external">
                        <a href="/index.php" target="_blank"><i class="fa fa-home"></i> 홈페이지</a>
                    </li>
                    <li class="external">
                        <a href="https://www.hometax.go.kr/" target="_blank"><i class="fa fa-external-link-square"></i> 국세청 홈택스</a>
                    </li>
                </ul>
            </li>
            <!-- settings end -->
        </ul>
        <!--  notification end -->
    </div>
    <div class="top-nav ">
        <!--search & user info start-->
        <ul class="nav pull-right top-menu">
            <li>
                <input type="text" class="form-control search" placeholder="Search">
            </li>
            <!-- user login dropdown start-->
            <li class="dropdown">
                <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                    <i class="fa fa-user-secret"></i>
                    <span class="username">관리자</span>
                    <b class="caret"></b>
                </a>
                <ul class="dropdown-menu extended logout">
                    <div class="log-arrow-up"></div>
                    <li><a href="/admin/setting/admin_setup.php"><i class=" fa fa-suitcase"></i> 정보설정</a></li>
                    <li><a href="/admin/"><i class="fa fa-key"></i> Log Out</a></li>
                </ul>
            </li>
            <!-- user login dropdown end -->
        </ul>
        <!--search & user info end-->
    </div>
</header>
