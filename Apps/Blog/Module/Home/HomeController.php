<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Module\Home;

use Core\Control\Button\Button;
use Core\Controller\Controller;

 class HomeController extends Controller
 {
	  /**
	   * Constructeur
	   */
	  function HomeBlock($core="")
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
                //Bouton pour créer un blog
                $btnNewBlog = new Button(BUTTON);
                $btnNewBlog->Value = $this->Core->GetCode("Blog.NewBlog");
                $btnNewBlog->CssClass = "btn btn-info";
                $btnNewBlog->OnClick = "BlogAction.ShowAddBlog();";
                
                $btnMyBlog = new Button(BUTTON);
                $btnMyBlog->Id = "btnInBox";
                $btnMyBlog->Value = $this->Core->GetCode("Blog.MyBlog");
                $btnMyBlog->CssClass = "btn btn-success";
                $btnMyBlog->OnClick = "BlogAction.LoadMyBlog();";
              
              
	        //Passage des parametres à la vue
                $this->AddParameters(array('!titleHome' => $this->Core->GetCode("Blog.TitleHome"),
                                            '!messageHome' => $this->Core->GetCode("Blog.MessageHome"),
                                            '!btnNewBlog' =>  $btnNewBlog->Show(),                     
                                            '!btnMyBlog' => $btnMyBlog->Show(),
                                            ));

                $this->SetTemplate(__DIR__ . "/View/HomeBlock.tpl");

                return $this->Render();
	  }
          
          /**
           * Obtient le menu
           */
          function GetMenu()
          {
              if(MessageHelper::HaveMessageNotRead($this->Core))
              {
                  $class='MessageNotRead';
              }   
              else
              {
                  $class='MessageRead';
              }
              
              $html = "<ul class='blueOne alignLeft'>";
              $html .= "<li><a href='#' onclick='EeMessageAction.LoadInBox()'  class='icon-envelope'>&nbsp;".$this->Core->GetCode("EeMessage.InBox")." (<span id='spNbInMessage' class=".$class.">".MessageHelper::GetNumberInBox($this->Core) ."</span>) </a></li>";
              $html .= "<li><a href='#' onclick='EeMessageAction.LoadOutBox()' class='icon-envelope-alt'>&nbsp".$this->Core->GetCode("EeMessage.OutBox")." (<span id='spNbOutMessage' >".MessageHelper::GetNumberOutBox($this->Core)."</span>)</a></li>";
              $html .= "</ul>";
              
              return $html;
          }
 }?>