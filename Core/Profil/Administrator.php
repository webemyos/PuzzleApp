<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class Administrator 
{
    /**
     * Obtien le menu d'un développeur
     */
    public static function GetMenu($core)
    {
    }
    
    /**
     * Obtient le tableau de bord
     * @param type $core
     */
    public static function GetDashBoard($core)
    {
        $html = "<div class='row'><div class='content-panel' id='dashBoard'>";
        
        
        $html .= "<h2 class='icon-dashboard blueTwo'>&nbsp".$core->GetCode("MyDashBoard")."</h2><div>";
        $html .= "<div class='row'> ";
    
        $apps = array("EeAdmin",  "EeAnnoncer" );
        
        foreach($apps as $app)
        {
            $html .= "<div class='widget col-md-3'>";
            $html .= "<div class='sub_widget'>";
            $html .= "<div class='title'>";
            $html .= "<i class='icon-desktop launcher' onclick='Eemmys.StartApp(\"\", \"".$app."\")'>&nbsp;</i>".$app;
            $html .= "</div>";        
            
           $EeApp = Eemmys::GetApp($app, $core);
           $html .= $EeApp->GetInfo();
           
                   
           $html .= "</div></div>";
            
        }
        
        $html .= "</div>";
       
        //Elements des communautées
        $html .= "<h2 class='icon-dashboard' >".$core->GetCode("WhatNews")."</h2>";
        $html .= "<div class='row' id='appRundashBoard'> ";
        $html .= "<div class='widget col-md-12'  >";
        
        $html .=  "";
       
        //Affichage des applications sous forme de widget
        $apps = array( "EeProjet" , "EeComunity" );
        $apps = array();
        
        foreach($apps as $app)
        {
          $EeApp = Eemmys::GetApp($app, $core);
         
          $html .= "<div class='col-md-6 'style='border:1px solid grey; border-radius : 5px 2px; background-color: #fafafa' ><h2>".$core->GetCode("Title" .$app)."</h2>";
                 
           $html .= $EeApp->GetInfoPublic()."</div>";
          //Ajout de l'onglet 
        }
        
        $html .= "</div>";
        $html .= "</div>";
        
        return $html;
    }
    
      /**
     * Obtient l'aide
     */
    public static function GetHelp($core)
    {
        if( isset($_GET["new"]) || isset($_GET["projet"]))
        {
            $html ="
                        <script type='text/javascript'>
                          $(window).load(function() {
                           	 	var params = Array();
                                    params['Title'] = 'Welcome';
    
                                Eemmys.OpenPopUp('Eemmys','ShowHomeNew', '','','', '', serialization.Encode(params), '');
                            }
                          );
                        </script>
                    ";

                    return $html ;
        }
    }
}

?>
