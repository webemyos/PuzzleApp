<?php
/**
 * JHomFramework 
 * Webemyos.com - la plateforme collaborative pour les startups
 * Oliva Jérôme
 * 02/11/2015
 * */

//type de dtd
define("STRICT","strict");
define("TRANSI"," transitional");
define("FRAME","frameset");

//position dans la page
define("HEAD","head");
define("LEFT","left");
define("CENTER","center");
define("RIGHT","right");
define("FOOT","footer");

//type de bouton
define("SUBMIT","submit");
define("BUTTON","button");

//type d'envoi de formulaire
define("GET","get");
define("POST","post");

//type de control
define("TEXTBOX","Core\Control\TextBox\TextBox");
define("PASSWORD","Core\Control\PassWord\PassWord");
define("NUMERICBOX","Core\Control\NumericBox\NumericBox");
define("TEXTAREA","Core\Control\TextArea\TextArea");
define("HIDDEN","Core\Control\Hidden\Hidden");
define("EMAILBOX","Core\Control\EmailBox\EmailBox");
define("TELBOX","Core\Control\TelBox\TelBox");

define("CHECKBOX","Core\Control\CheckBox\CheckBox");
define("DATEBOX","Core\Control\DateBox\DateBox");
define("DATETIMEBOX","Core\Control\DateTimeBox\DateTimeBox");
define("IMAGE","Core\Control\Image\Image");

//type d'operateur de requete
define("EQUAL","Equal");
define("NOTEQUAL","NotEqual");
define("IN","In");
define("NOTIN","NotIn");
define("BETWEEN","Between");
define("LESS","Less");
define("MORE","More");
define("LIKE","Like");
define("ALL","All");
define("ISNULL","IsNull");

//type d'evenement
define("OPENWIN","OpenWin");
define("LOADWIN","LoadWin");
define("CLOSEWIN","CloseWin");
define("CLOSELOAD","CloseLoad");

//type d'entite
define("BLOC","Bloc");
define("PAGE","Page");
define("CONTROL","Control");

//Type de Log
define("CORE","Core");
define("DB","Db");
define("EN","En");

//Type de jointure
define("LEFTJOIN","left");
define("INNERJOIN","inner");
define("RIGHTJOIN","right");

//Niveau de log
define("All","");
define("ERR","ERR");
define("INFO","INFO");

//Constante des templates
define("EDIT","Edit");
define("DELETE","Delete");

//A MODIFIER
define("LogLEVEL","ERR");
define("ROOT",1);

//Constante de style css
define("ALIGNRIGHT","style='text-align:right;'");
define("ALIGNLEFT","style='text-align:left;'");
define("ALIGNCENTER","style='text-align:center;'");

//Type de base de donnee
define("XML","xml");

//Type de mode ouverture des pages
define("OPENMODE","openMode");
define("WINDOWS","Windows");
define("POPUP","PopUp");

define("EDITMODE","EDITMODE");
define("SIMPLE","Simple");
define("ADVANCED","Advanced");

//contact du site
define("EMAIL_CONTACT","contact@webemyos.com");


//Code Erreur
define("ACTION","Action");
define("RESULT","Result");
define("OK","000");
define("KO","999");

//Type de news
define("STATUT","Statut");
define("FRIENDS","Friends");
define("CONTACTS","Contacts");
define("GEOMIXER","Geomixer");



//Email D'envoi
define("WEBEMYOSMAIL","contact@webemyos.com");


// Code Erreur
define("ERROR","Err");
define("ERR_PASSWORD","Password invalide");
define("ERR_USER_NOT_EXIST","User existe pas");
define("ERR_USER_EXIST","User existe");
define("ERR_ADD_USER","Erreur ajout user");
define("ERR_USER_NOT_CONNECT","User non connecte");
define("ERR_FILE_NOT_DEFINED","File non definie");
define("ERR_USER_FILE_NOT_FOUND","File or user non trouve");
define("ERR_ADD_COMMENT","Erreur ajout commentaire");
define("ERR_USER_NOT_IMAGE","User n'a pas d'image");

//Code Erreur Fichier
define("ERR_NO_FILE","Fichier de taille nulle"); // Fichier de taille nulle
define("ERR_INI_SIZE","Fichier trop lourd pour le serveur"); // Fichier trop lourd limite par le serveur
define("ERR_FORM_SIZE","Fichier trop lourd pour le formulaire"); //Fichier trop lourd limit par le formulaire
define("ERR_PARTIAL","Problème de transfert"); // Problème de transfert

//Code valide
define("ADDUSER","Ajout User");
define("URLSITE", "http://Webemyos.com");
define("URLSITEMEMBRE","");
define("URLDATAMEMBRE","Data");

define("MAXSIZEUSER", "200000000")

?>