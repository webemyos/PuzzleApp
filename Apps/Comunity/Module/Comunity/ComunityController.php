<?php
/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Comunity\Module\Comunity;

use Apps\Comunity\Helper\ComunityHelper;
use Core\Control\Button\Button;
use Core\Controller\Controller;


 class ComunityController extends Controller
 {
    /**
     * Constructeur
     */
    function __construct($core="")
    {
        $this->Core = $core;
    }

    /**
     * Creation
     */
    function Create()
    {
    }

    /**
     * Initialisation
     */
    function Init()
    {
    }

    /**
     * Affichage du module
     */
    function Show($all=true)
    {
    }


    /**
     * Charge les communauté de l'utilisateur
     */
    function LoadMyComunity()
    {
        //Recuperation 
        $comunitys = ComunityHelper::GetByUser($this->Core);

        if(count($comunitys) > 0)
        {

        //Entete
        $html .= "<div class='headComunity titleBlue'  >";
        $html .= "<b>&nbsp;</b>" ;
        $html .= "<span><b>".$this->Core->GetCode("Name")."</b></span>" ;
        $html .= "<span><b>".$this->Core->GetCode("Description")."</b></span>" ;
        $html .= "</span>";  
        $html .= "</div>" ;

         foreach($comunitys as $comunity)
         {
             $html .= "<div class='Comunity'  >";
             $html .= "<span class='name' >".$comunity->Comunity->Value->Name->Value."</span>" ;
             $html .= "<span >".$comunity->Comunity->Value->Description->Value."</span>" ;

             //Bouton d'ajout
             $btnAdd = new Button(BUTTON);
             $btnAdd->Value = $this->Core->GetCode("EeComunity.Remove");
             $btnAdd->OnClick = "EeComunityAction.Remove(".$comunity->IdEntite.", this)";

             $html .= "<span class='' >".$btnAdd->Show()."</span>" ;

             $html .= "</div>";
         }
        }
        else
        {
            $html .= $this->Core->GetCode("EeComunity.NoComunity");
        }

        return $html;
    }

    /*
     * Charge les communautés
     */
    function Load()
    {
        //Recuperation 
        $comunitys = ComunityHelper::GetAll($this->Core);

        //Entete
        $html .= "<div class='headComunity titleBlue'  >";
        $html .= "<b>&nbsp;</b>" ;
        $html .= "<span><b>".$this->Core->GetCode("Name")."</b></span>" ;
        $html .= "<span><b>".$this->Core->GetCode("Description")."</b></span>" ;
        $html .= "</span>";  
        $html .= "</div>" ;

         foreach($comunitys as $comunity)
         {
             $html .= "<div class='Comunity'  >";
             $html .= "<span class='name' >".$comunity->Name->Value."</span>" ;
             $html .= "<span>".$comunity->Description->Value."</span>" ;

             //Si l'utilisateur ne la pas dèjà ajouté
             if(!ComunityHelper::UserHave($this->Core, $comunity->IdEntite))
             {
                  //Bouton d'ajout
                  $btnAdd = new Button(BUTTON);
                  $btnAdd->Value = $this->Core->GetCode("EeComunity.Add");
                  $btnAdd->OnClick = "EeComunityAction.Add(".$comunity->IdEntite.", this)";

                  $html .= "<span>".$btnAdd->Show()."</span>" ;
             }

             $html .= "</div>";
         }

        return $html;
    }
 }?>