<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
/**
 * Module ClientBlock
 * */
 class ClientBlock extends JHomBlock implements IJhomBlock
 {
        
        protected $Commerce;
     
    	  /**
	   * Constructeur
	   */
	  function ClientBlock($core="")
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
          
          /*
           * Obtient les module clients
           */
          function GetModule($module)
          {
              switch($module)
              {
                 case "commande";
                      return $this->GetCommande();
                 break;
                 case "favoris";
                      return $this->GetFavoris();
                 break;
              }
          }
          
          /*
           * Obtient les commandes de l'utilisateur
           */
          function GetCommande()
          {
              $modele = new JModele( "Apps/EeCommerce/Blocks/ClientBlock/View/GetCommande.tpl", $this->Core); 
              
              //Recuperation des commandes de l'utilisateur
              $commandes = CommandeHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
              $modele->AddElement($commandes);
                      
              return $modele->Render();
          }
          
          /*
           * Obtient les favoris de l'utilisateur
           */
          function GetFavoris()
          {
              $modele = new JModele( "Apps/EeCommerce/Blocks/ClientBlock/View/GetFavoris.tpl", $this->Core); 
              
              //Recuperation des commandes de l'utilisateur
              $likes = LikeHelper::GetByUser($this->Core, $this->Core->User->IdEntite);
              
              if(count($likes) > 0)
              {
                $modele->AddElement($likes);
              }
              else
              {
                $modele->AddElement(array());
              }
              
              return $modele->Render();
          }
 }