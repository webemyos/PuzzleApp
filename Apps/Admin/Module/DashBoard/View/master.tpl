<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="Dashboard">
    <meta name="keyword" content="Dashboard, Bootstrap, Admin, Template, Theme, Responsive, Fluid, Retina">

    <title>Admin</title>

    <!-- Bootstrap core CSS -->
    <link href="{{GetPath(/asset/bootstrap.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/fontawesome.min.css)}}" rel="stylesheet">
    <!--external css-->
 
    <!-- Custom styles for this template -->
    <link href="{{GetPath(/asset/style.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/style-responsive.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/desktop.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/jquery-ui.css)}}" rel="stylesheet">
    
    <script src='{{GetPath(/script.php)}}' ></script>
    <script src='{{GetPath(/script.php?s=Dashboard)}}' ></script>  
    <script src='{{GetPath(/js/ckeditor/ckeditor.js)}}' ></script>  
 
    
    <!-- HTML5 shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  <body>

  <section id="container" >
      <!-- **********************************************************************************************************************************************************
      TOP BAR CONTENT & NOTIFICATIONS
      *********************************************************************************************************************************************************** -->
      <!--header start-->
      <header class="header black-bg">
              <div class="sidebar-toggle-box">
                  <div class="fa fa-bars tooltips" data-placement="right" data-original-title="Toggle Navigation"></div>
              </div>
            <!--logo start-->
            <a href="index.html" class="logo"><b>PuzzleApp</b></a>
            <!--logo end-->
            <div class="nav notify-row" id="top_men">
                <!--  notification start -->
                <ul class="nav top-menu">
                    <!-- App -->
                    <li class="dropdown">
                        <div id='tdApp' class='span8'>
                        </div>
                    </li>
                    <!-- App end -->
                    <!-- inbox dropdown end -->
                </ul>
                <!--  notification end -->
            </div>
           
            <div class="top-menu">
            	<ul class="nav pull-right top-menu">
                    <li><div id='tdApp' class='top-menu'>
                        </div>
                    </li>    
                    <li><a href="Disconnect" class='logout'><i class="fa fa-power-off"></i>&nbsp;{{GetCode(membre.Logout)}}</a></a></li>
            	</ul>
            </div>
        </header>
      <!--header end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN SIDEBAR MENU
      *********************************************************************************************************************************************************** -->
      <!--sidebar start-->
      <aside>
          <div id="sidebar"  class="nav-collapse ">
              <!-- sidebar menu start-->
              <ul class="sidebar-menu" id="nav-accordion">
                  <li class="mt" id="btnStart">
                      <a href="javascript:;" >
                      <i class="fa fa-dashboard"></i>
                          <span>{{GetCode(membre.myDashboard)}}</span>
                      </a>
                  </li>
                  <li class="sub-menu">
                      <a href="javascript:;" >
                          <i class="fa fa-desktop"></i>
                          <span>{{GetCode(membre.myApplications)}}</span>
                      </a>
                      <ul class="subsss">
                          {{appUser}}
                      </ul>
                  </li>
            </ul>
              <!-- sidebar menu end-->
          </div>
      </aside>
      <!--sidebar end-->
      
      <!-- **********************************************************************************************************************************************************
      MAIN CONTENT
      *********************************************************************************************************************************************************** -->
      <!--main content start-->
      <section id="main-content">
          <section class="wrapper site-min-height">
          	<div class="row mt">
          		<div class="col-lg-12">
                            <div id='dvCenter'>
                                <div class='App row-fluid white-panel pn'>
                                <h2>Bienvenue sur la partie administration de votre site.</h2>
                                <p>Cette section permet de gérer votre site.</p>
                                <p>Vous pouvez ajouter des applications depuis le bouton à gauche ("AddApp").</p>
                                </div>
                            </div>
          		</div>
          	</div>
		</section><! --/wrapper -->
      </section><!-- /MAIN CONTENT -->

      <!--main content end-->
      <!--footer start-->
      <footer class="site-footer">
          <div class="text-center">
              PuzzleApp - PuzzeApp.com
              <a href="blank.html#" class="go-top">
                  <i class="fa fa-angle-up"></i>
              </a>
          </div>
          
        <div id='context'>
        </div>
      </footer>
      <!--footer end-->
  </section>
    !script
   </body>
</html>

