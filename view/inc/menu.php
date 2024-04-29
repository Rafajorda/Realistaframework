<!-- menu.php -->
<div class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <div class="navbar-brand " >
                <a href="index.php?page=homepage">
                    <img src="view\img\realistalogo.png" alt="Your Logo"  style="width: 150px; height: auto;">
                </a>
            </div>
            <div class="header__container">
                <div class="search__form">
                    <select id="ahorro_vivienda"></select>
                    <select id="type_vivienda"></select>
                    <input type="text" id="autocom" autocomplete="off" placeholder="City" />
                    <div id="search_vivienda"></div>
                    <input type="button" value="..." id="search-btn" />
                    <ul id=nav_desp_user>
                        <li class="log_princ" style="width:50px;height:50px;"><button class="log-icon"></button>
                            <ul>
                                <li id="des_inf_user"></li>
                            </ul>
                        </li>
                    </ul>
                </div>   
            </div>      
        </div>
        <div class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                 <!-- <li><a href="index.php?page=login">login</a></li> -->
                 <li><a class= "login-button-menu"></a></li>
                <li><a href="index.php?page=homepage">HOME</a></li>               
                <li><a href="index.php?page=shop">SHOP</a></li>    
            </ul>
        </div>
    </div>
</div>