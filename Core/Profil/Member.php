<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

class Member 
{
    /**
     * Obtien le menu d'un développeur
     */
    public static function GetMenu($core)
    {
    }
    
    /*
     * Obtient les differents modules
     */
    public static function GetDashBoard($core)
    {
        $modele = new JModele("Template/DashBoard.tpl", $core);
        
        //Bannier pour le concours
        $banner = Eemmys::GetApp("EeBanner", $core);
        $modele->AddElement(new Text("banner", false, $banner->GetBanner("webemyosDashboard")));
      
        $EeApp = Eemmys::GetApp("EeProjet", $core);
        $modele->AddElement(new Text("InfoProjetUser", false, $EeApp->GetDashboard()));
        
        $modele->AddElement(new Text("InfoProjet", false, $EeApp->GetInfoPublic()));
        
        $EeApp = Eemmys::GetApp("EeComunity", $core);
        $modele->AddElement(new Text("InfoCommunity", false, $EeApp->GetInfoPublic()));
        
        return $modele->Render();
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
