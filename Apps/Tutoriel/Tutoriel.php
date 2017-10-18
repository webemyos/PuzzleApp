<?php


/**
 * Description of PuzzleApp
 *
 * @author jerome
 */

namespace Apps\Tutoriel;

use Apps\Mooc\Mooc;
use Core\Core\Core;

/**
 * Description of Base
 *
 * @author jerome
 */
class Tutoriel extends Mooc
{
    /**
    * Constructeur
    */
   function __construct($core="")
   {
       $this->Core = $core;
       parent::__construct($this->Core, "Tutoriel", "Tutoriel");
   }
   
   /*
    * Home Index
    */
   function Index()
   {
      $this->Core->MasterView->Set("Title", "Apprenez à utiliser PuzzleApp");
      $this->Core->MasterView->Set("Description", "PuzzleApp un framework simple d'utilisation. Des application simples et intuitives qui vous permettent de faire quelques pas. Apprenez à l'utiliser dans nos tutoriels dédiés que vous soyez utilisateur, développeur, graphiste, un peu geek.");

      return Parent::Index();
   }
   
   /*
    * 
    */
   function Mooc($params)
   {
      return "TEST : " . Parent::Mooc($params); 
   }
}
