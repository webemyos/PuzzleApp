<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\View;

use Core\Utility\File\File;


use Core\Control\Text\Text;
use Core\View\ViewManager;
use Core\View\FunctionManager;

/*
 * Classe de gestion des modèle
 */
class View
{
    /**
     * Template à utiliser
     * @var type
     */
    private $Template;
    private $Elements = array();
    private $Core;
    private $Model;

    /*
     * Constructeur
     */
    public function __construct($template, $core = "")
    {
        $this->Core = $core;

        $this->Template = ViewManager::Find($template);

    }

    /*
     * Set à element
     */
    public function Set($name, $text)
    {
        $element = new Text($name, false, $text);

        $this->AddElement($element);
    }

    /**
     * Ajoute un element
     * @param type $element
     */
    public function AddElement($element)
    {
        $this->Elements[] = $element;
    }

    /*
     * SetModel
     */
    public function SetModel($model)
    {
        $this->Model = $model;
    }
    /*
    * Utiliser dans les tab strip
    */
    public function Show()
    {
        return $this->Render();
    }

    /*
     * Génère le code html depuis
     */
    public function Render()
    {
        //Recuperation du contenu
        $html = File::GetFileContent($this->Template);

        //Remplacement des elements
        foreach($this->Elements as $element)
        {
            //Collections d'elements
            if(is_array($element))
            {
                $html = $this->LoadCollections($html, $element);
            }
            //Control
            else if( (get_parent_class($element) == "Core\Control\Control" || get_parent_class($element) == "Core\Block\Block" ))
            {
               $html = str_replace("{{".$element->Id."}}", $element->Show(), $html);
            }
            else if(get_class($element) == "Text")
            {
                $html = str_replace("{{".$element->Name."}}", $element->Text, $html);
            }
            else if(get_class($element) == "Block")
            {
                $html = str_replace("{{".$element->Id."}}", $element->Show(), $html);
            }
            else if(get_class($element)== "Core\View\ElementView")
            {
                $html = ViewManager::ReplaceElement($html, $element);
            }
            //Remplacement du champ par la propriete de l'objet
            else if(get_class($element)== "Core\View\ContentView")
            {
                $html = ViewManager::ReplaceContent($html, $element);
            }
            else
            {
                $html = $this->LoadProperty($html, $element);
            }
        }

        $html = FunctionManager::LoadSpecialFunction($this->Core, $html);

        //Replace the element model
        if($this->Model != null)
        {   
            $html = ViewModelManager::ReplaceModel($html, $this->Model);
        }
               
        return $html;
    }

    /*
     * Load Collections
     */
    function LoadCollections($html, $element)
    {
        //On extrait la ligne a convertir
        $start = strpos($html, "{{foreach}}");
        $end = strpos($html, "{{/foreach}}");

        //On récupere la ligne entre les foreach
        $line = substr($html, $start, $end - $start);
        $lines = "";

        $startPhp = strpos($line, "php");
        $endPhp = strpos($line, "!php");
        $codePhp = substr($line , $startPhp, $endPhp - $startPhp);

        if(count($element) > 0)
        {
            //Ajout des élements
            foreach($element as $elm)
            {
                $newLine = $line;

                //Remplacement des Identifiants
                $newLine = str_replace("{{element->IdEntite}}", $elm->IdEntite, $newLine);
                $newLine = $this->LoadElementProperty($elm, $html, $newLine );
                $newLine = $this->LoadFunction($elm, $html, $newLine );

                //Ajout de la ligne
                $lines .= $newLine;
            }

            $html = str_replace($line, $lines, $html) ;

        }
        else
        {
            $html = str_replace($line, "NO ELEMENT", $html) ;
        }

             $html = str_replace("{{foreach}}", "", $html) ;
            $html = str_replace("{{/foreach}}", "", $html) ;

        return $html;
    }

    /*
     * Remplace les champs par les valeurs de
     */
    function LoadElementProperty($elm, $html, $newLine)
    {
        //Remplacement des propriete enfant
        $pattern = "`{{element->(.+)->Value->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           $subprop = $macthes[2][$i];

           $newLine = str_replace($match, $elm->$prop->Value->$subprop->Value, $newLine);
           $i++;
        }

        //Remplacement des proprietes
        $pattern = "`{{element->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           
           if(isset($elm->$prop))
           {
            $newLine = str_replace($match, $elm->$prop->Value, $newLine);
           }
           $i++;
        }

       // return $newLine;
        
        //Remplacement des if
        $pattern = "`{{if element->(.+)->Value == (.+)}}`";
        
        preg_match_all($pattern, $newLine, $macthes);
        $i = 0;
// var_dump($macthes);
 
        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           $value = $macthes[2][$i];

           $start = strpos($html, "{{if element->$prop->Value == $value}}");
           $end = strpos($html, "{{/if}}");
           
           $line = substr($html, $start, $end - $start);
      
           echo $elm->$prop->Value ."== " .$value ;
           
           if($elm->$prop->Value == $value)
           {
               $newLine = $line;
           }
           else
           {
             $newLine = str_replace($line, "dddd", $html);
          }
           
           $i++;
        }
        
        
        return $newLine;
    }

    /*
     * Remplace les fonctions
     */
    public function LoadFunction($elm, $html, $newLine)
    {
        //Remplacement des fonctions enfant
        $pattern = "`{{element->(.+)->Value->(.+)\(\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           $subprop = $macthes[2][$i];

           $newLine = str_replace($match, $elm->$prop->Value->$subprop(), $newLine);
           $i++;
        }

        //Remplacement des proprietes
        $pattern = "`{{element->(.+)\(\)}}`";
        preg_match_all($pattern, $newLine, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $func = $macthes[1][$i];
           $newLine = str_replace($match, $elm->$func(), $newLine);
           $i++;
        }

        return $newLine;
    }

    /*
     * Load Property
     */
    public function LoadProperty($html, $element)
    {
        //Remplacement des propriete enfant
        $pattern = "`{{element->(.+)->Value->(.+)->Value}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $prop = $macthes[1][$i];
           $subprop = $macthes[2][$i];

           $html = str_replace($match, $element->$prop->Value->$subprop->Value, $html);
           $i++;
        }

        //Recuperation des proriete de l'elemens
        $propertys = $element->GetProperty();

        // Remplacement des propriétés
        foreach($propertys as $property)
        {
           $nameProperty = $property->GetName();
           $html = str_replace("{{element->".$nameProperty."->Value}}", $element->$nameProperty->Value, $html);
        }

         //Remplacement des Identifiants
         $html = str_replace("{{element->IdEntite}}", $element->IdEntite, $html);

        $pattern = "`{{element->(.+)\(\)}}`";
        preg_match_all($pattern, $html, $macthes);
        $i = 0;

        foreach($macthes[0] as $match)
        {
           $func = $macthes[1][$i];
           $html = str_replace($match, $element->$func(), $html);
           $i++;
        }

        return $html;
    }



    //Charge les control depuis l'entite
    public function LoadControl($entity)
    {
        foreach($entity->GetProperty() as $property  )
        {
          $property->Load();
        }
    }
    
    /*
     * Show or Hide content
     */
    public function LoadIf($html, $element)
    {
         //On extrait la ligne a convertir
        $start = strpos($html, "{{if $key}}");
        $end = strpos($html, "{{/if $key}}");
  
        
    }
}
