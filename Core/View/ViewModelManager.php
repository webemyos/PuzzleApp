<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\View;

use Core\Control\Button\Button;
use Core\Control\EntityListBox\EntityListBox;
use Core\Core\Core;


class ViewModelManager 
{
    /*
     * Replace teh element model
     */
    public static function ReplaceModel($html, $model, $ajax, $app, $action)
    {
        $model->Prepare();
        $model->Updated();
        
        $html = ViewModelManager::RenderModel($html, $model, $ajax, $app, $action);
        $html = ViewModelManager::RenderState($html, $model, "Init");
        $html = ViewModelManager::RenderState($html, $model, "Updated");
        
        return $html;
    }
    
    /*
     * Render the model complete
     */
    public static function RenderModel($html, $model, $ajax, $app, $action)
    {
        $core = Core::getInstance();
        
        if(!$ajax)
        {
            $content ="<form method='post'>";
        }
        else
        {
            $content = "<div id='ajaxModel'> ";
            $content .= "<div id='error' class='error'></div>";
            $content .= "<input type='hidden' id='app' value=".$app." >";
            $content .= "<input type='hidden' id='action' value=".$action." >";
            
            if($model->GetEntity()->IdEntite != "")
            {
                $content .= "<input type='hidden' name='entityId' value=".$model->GetEntity()->IdEntite." >";
            }
        }
        
        $properties = $model->GetEntity()->GetProperty();
        
        foreach($properties as $propertie)
        {
            if(!in_array($propertie->Name, $model->GetExcludes()))
            {
                $control = new $propertie->Type($propertie->Name);
                $control->Value = $propertie->Value;
  
                if($propertie->Obligatory )
                {
                    $control->Required = true;
                }

                $content .= $propertie->Libelle;
                  
                $content .= $control->Show();
            }
        }
     
        $entityProperty = $model->GetEntity()->GetEntityProperty();
      //  echo count($entityProperty);
        
        foreach($entityProperty as $propertie)
        {
            if(!in_array($propertie->Entity, $model->GetExcludes()))
            {
                $entityListBox = new EntityListBox($propertie->EntityField, $core);
                $property =$propertie->EntityField;
                $entityListBox->Entity =$propertie->Entity; 
                
                $entityListBox->Selected = $model->GetEntity()->$property->Value;
                        
                $content .= $entityListBox->Show();
            }
        }
        
        if(!$ajax)
        {
            $button = new Button(SUBMIT);
            $button->CssClass = "btn btn-success";
            $button->Value = $core->GetCode("Save");
            $content .= $button->Show();

            $content .= "</form>";
        }
        else
        {
            $button = new Button(BUTTON);
            $button->CssClass = "btn btn-success";
            $button->OnClick = "Dashboard.UpdateModele()";
            $button->Value = $core->GetCode("Save");
            $content .= $button->Show();
            
            $content .= "</div>";
        }
        
        $html = str_replace("{{RenderModel()}}", $content, $html);
        
        return $html;
    }
    
    /*
     * Render content if model is init
     */
    public static function RenderState($html, $model, $state)
    {
         $start = strpos($html, "{{if Model->State = ".$state."}}");
         $end = strpos($html, "{{/if Model->State = ".$state."}}");
           
         $line = substr($html, $start, $end - $start);
        
         if($model->GetState() == $state)
         {
             $html = str_replace("{{if Model->State = ".$state."}}", "", $html);
             $html = str_replace("{{/if Model->State = ".$state."}}", "", $html);
         }
         else
         { 
            $html = str_replace($line, "", $html);
            $html = str_replace("{{/if Model->State = ".$state."}}", "", $html);
         }
         
         return $html;
    }
}
