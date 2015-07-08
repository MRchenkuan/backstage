<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container-fluid">
        <!--品牌图标-->
        <div class="navbar-header">
            <a class="navbar-brand" href="#">
                <span class="glyphicon glyphicon-cog"></span>
                <span class="glyphicon glyphicon-book"></span>
                <span class="glyphicon glyphicon-list-alt"></span>
                <span class="glyphicon glyphicon-user"></span>
            </a>
        </div>
        <!--导航菜单-->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <!--导航选项-->
                <li class="<?php echo $pageID=='home'?'active':'default' ?>"><a href="./home.php">首页</a></li>
                <li class="<?php echo $pageID=='addAdvt'?'active':'default' ?>"><a href="./addAdvt.php">广告管理</a></li>
                <li class="<?php echo $pageID=='addNews'?'active':'default' ?>"><a href="./addNews.php">新闻管理</a></li>
                <li class="<?php echo $pageID=='photoLib'?'active':'default' ?>"><a href="./albums.php">图库管理</a></li>
                <li class="<?php echo $pageID=='remarkManager'?'active':'default' ?>"><a href="./remarkManager.php">评论管理</a></li>
            </ul>
        </div>
    </div>
</nav>

