<?php
/**
 * Module AdminBlock
 * */
 class AdminBlock extends JHomBlock implements IJhomBlock
 {
	  /**
	   * Constructeur
	   */
	  function AdminBlock($core="")
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
              $tabAdmin = new TabStrip("tabAdmin", "EeCommerce");
                      
              //Inclue les différents outils
              $tools = array(array("Sale", "icon-Dollar"),
                             array("Product", "icon-Book"),
                             array("Shop","icon-asterisk")
                  );
              
              foreach($tools as $tool)
              {
                $blockName = $tool[0]. "Block";
                    
                //Ajout de différents outils
                 include($blockName.".php");
                  
                  $block = new $blockName($this->Core);
                  
                  $html = "<div class='row'>";
                  $html .= "<div class='col-md-10'>";
                  $html .= $block->GetTool()->Show();
                  $html .= "</div>";
                  $html .= "<div class='col-md-2'>";
                  $html .= $block->GetHelp();
                  $html .= "</div></div>";
                  $tabAdmin->AddTab("&nbsp;".$tool[0], new Libelle($html), "","", $tool[1]);
              }
              
              
              return $tabAdmin->Show();
	  }
          
          /*
           * Ajout d'un utilisateur
           */
          function ShowAddUser($userId)
          {
             $jbUser = new AjaxFormBlock($this->Core, "jbUser");
            $jbUser->App = "EeCommerce";
            $jbUser->Action = "SaveUser";

            
            if($userId != "")
            {
                $user = new User($this->Core);
                $user->GetById($userId);

                $jbUser->AddArgument("userId", $userId);
            }

            //Ajout des champs
            $jbUser->AddControls(array(
                                          array("Type"=>"TextBox", "Name"=> "tbNameUser", "Libelle" => $this->Core->GetCode("Name"), "Value" => ($user != null) ? $user->Name->Value : ""  ),
                                          array("Type"=>"TextBox", "Name"=> "tbFirstNameUser", "Libelle" => $this->Core->GetCode("FirstName"), "Value" => ($user != null) ? $user->FirstName->Value : "" ),
                                          array("Type"=>"TextBox", "Name"=> "tbEmailUser", "Libelle" => $this->Core->GetCode("Email"), "Value" => ($user != null) ? $user->Email->Value : "" ),
                                          array("Type"=>"EntityListBox", "Name"=> "lstGroup", "Entity"=>"Group",  "Libelle" => $this->Core->GetCode("Group"), "Value" => ($user != null) ? $user->GroupeId->Value : "" ),
                                          
                                          array("Type"=>"Button", "Name"=> "BtnSave" , "CssClass" => "btn btn-primary" , "Value" => $this->Core->GetCode("Save")),
                              )
                    );


            return $jbUser->Show();
          }
          
          /*action*/
 }?>