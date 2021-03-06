<html>
   <head>
    <title>{{Title}}</title>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="{{Description}}">
    <meta name="author" content="Webemyos.com">
    <link rel="icon" href="Images/favicon-tnp.ico">
    <link href="{{GetPath(/asset/bootstrap.css)}}" rel="stylesheet">
    <link href="{{GetPath(/asset/global.css)}}" rel="stylesheet">

    <script src='{{GetPath(/script.php)}}' ></script>
    

    <!-- Script
    ================================================== -->
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head>
  
    <body>
        <h1>Puzzle App</h1>
            <ul>
                <li><a href='Index'>{{GetCode(Home)}}</a></li>
                <li><a href='Contact'>{{GetCode(Contact)}}</a></li>
                {{if connected == false}}
                     <li><a href='Login'>{{GetCode(Connect)}}</a></li>
                {{/if connected == false}}
                   
                {{if connected == true}}
                      <li><a href='Admin'>{{GetCode(DashBoard)}}</a></li>
                {{/if connected == true}}
            </ul>
        
        {{content}}
    </body>
</html>