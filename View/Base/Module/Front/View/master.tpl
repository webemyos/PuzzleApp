<!DOCTYPE html>
<html lang="fr">
  <head>
    <title>{{Title}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{Description}}">
    <meta name="author" content="Webemyos.com">
    <meta name="google-site-verification" content="L01HplD_twKHENKQXEA0i44yTMXtgVOr6Iu_TIZ69aI" />
    <link rel="icon" href="Images/favicon-tnp.ico">
    <link href="{{GetPath(/asset/bootstrap.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/global.css)}}" rel="stylesheet">

    <script src='{{GetPath(/script.php)}}' ></script>
    <script src='{{GetPath(/script.php?a=Downloader)}}' ></script>
    <script src='{{GetPath(/script.php?a=Blog)}}' ></script>  


    <!-- Script
    ================================================== -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>

<!-- NAVBAR
  ================================================== -->
  <body>
    <div class="navbar-wrapper">
      <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
        <div class="container">
          <div class="navbar-header">
            <a class="navbar-brand" href="index.php" alt="PuzzleApp" title="Plus qu'un framework ...">
                  <img src='Images/logo-tnp.png' />
            </a>
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right">
                <li><a  class="last-item-menu" href="{{GetPath(/index)}}">Accueil</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/Tutoriel)}}">Tutoriel</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/download)}}">Téléchargement</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/store)}}">Le store</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/Blog)}}">Le blog</a></li>
            </ul>
          </div>
        </div>
      </nav>
    </div>

    <!-- Header Home
    ================================================== -->

    <div class="content">
      <div id="dvCenter">
        <div id="appRunLePupitreDigital" class="App row-fluid">
          <div id='appCenter'>
             <section class="full-bg-fixed home-bg" >
                <div class='content-main'>
                  <div class="container">
                    <div class="row" >
                        <div class='global-sub-block'>
                            <div class="row-fluid">
                                <div id="content-wrapper" class=""></div>

                                {{content}}

                                  <div class="col-md-7">

                                  </div>
                            </div>
                        </div>
                    </div>
                  </div>
                </div>
                <div class='clearfix'></div>
             </section>
          </div>
        </div>
      </div>
    </div>

    <!-- Footer
    ================================================== -->
    <footer>
      <div class="container">
        <hr class="footer-divider">
        <div class="row">
          <div class="col-xs-6 col-sm-3 hide-768"> <!-- Colonne 1 -->
            <ul>
                <li><a  class="last-item-menu" href="{{GetPath(/index)}}">Accueil</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/tutoriel)}}">Tutoriel</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/download)}}">Téléchargement</a></li>
                <li><a  class="last-item-menu" href="{{GetPath(/Blog)}}">Le blog</a></li>
            </ul>
          </div>
        </div>  <!-- ./row -->
        <hr class="footer-divider">
        <p class="pull-right"><a href="#">Back to top</a></p>
        <p><a href="#" alt="Copyright">© 2017 PuzzleApp</a></p>
      </div>
    </footer>

  <!-- Script
  ================================================== -->
  <script type='text/javascript'>
  $( document ).ready(function() {

    Eemmys.LoadLanguage();

    });
    
    wid
  </script>

  <script>
  (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
  (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
  m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
  })(window,document,'script','https://www.google-analytics.com/analytics.js','ga');

  ga('create', 'UA-76711078-1', 'auto');
  ga('send', 'pageview');

</script>

</body>
</html>
