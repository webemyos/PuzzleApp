<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Apps\Blog\Entity;

use Core\Control\Button\Button;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;

class BlogComment extends Entity  
{
    protected $User;
    
    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0"; 

        //Nom de la table 
        $this->Core=$core; 
        $this->TableName="BlogComment"; 
        $this->Alias = "BlogComment"; 

        $this->ArticleId = new Property("ArticleId", "ArticleId", NUMERICBOX,  true, $this->Alias); 
        $this->Message = new Property("Message", "Message", TEXTAREA,  true, $this->Alias); 
        $this->UserName = new Property("UserName", "UserName", TEXTBOX,  false, $this->Alias); 
        $this->UserEmail = new Property("UserEmail", "UserEmail", TEXTBOX,  false, $this->Alias); 
        $this->UserId = new Property("UserId", "UserId", NUMERICBOX,  false, $this->Alias); 
        $this->User = new EntityProperty("User", "UserId");
        $this->DateCreated =  new Property("DateCreated", "DateCreated", DATEBOX,  false, $this->Alias); 

        $this->Actif = new Property("Actif", "Actif", NUMERICBOX,  false, $this->Alias); 

        //Creation de l entité 
        $this->Create(); 
    }
    
    /*
     * Get Publish/UnPublish Button
     */
    public function GetBtnPublish()
    {
        if($this->Actif->Value == false)
        {
            $btnPublish = new Button(BUTTON);
            $btnPublish->CssClass = "btn btn-info";
            $btnPublish->Value = $this->Core->GetCode("Blog.Publish");
            $btnPublish->OnClick = "BlogAction.Publish(this, ".$this->IdEntite.", 1)";
            return $btnPublish->Show();
        }   
        else
        {
            $btnDePublish = new Button(BUTTON);
            $btnDePublish->CssClass = "btn btn-info";
            $btnDePublish->Value = $this->Core->GetCode("Blog.UnPublish");
            $btnDePublish->OnClick = "BlogAction.Publish(this, ".$this->IdEntite.", 0)";
            return $btnDePublish->Show();
        } 
    }
}
?>