<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Entity\User;

use Core\Control\Button\Button;
use Core\Control\CheckBox\CheckBox;
use Core\Control\Image\Image;
use Core\Core\Request;
use Core\Entity\Entity\Argument;
use Core\Entity\Entity\Entity;
use Core\Entity\Entity\EntityProperty;
use Core\Entity\Entity\Property;
use Core\Utility\File\File;
use Core\Utility\Format\Format;

/*
* Classe des utilisateurs
*/
class User extends Entity
{
    protected $Groupe;
    protected $Country;
    protected $City;
    protected $HomeTown;
    protected $Job;

    //Constructeur
    function __construct($core)
    {
        //Version
        $this->Version ="2.0.0.0";

        //Nom de la table
        $this->Core=$core;
        $this->TableName="ee_user";
        $this->Alias = "us";

        //Proprietes
        $this->GroupeId=new Property("GroupeId","GroupId",TEXTBOX,true,$this->Alias);
        $this->Groupe=new EntityProperty("Core\Entity\Group\Group","GroupeId");

        //Identifiant
        $this->Email =new Property($this->Core->GetCode("Email"),"Email",TEXTBOX,true,$this->Alias);
        $this->Pseudo =new Property($this->Core->GetCode("Pseudo"),"Pseudo",TEXTBOX,false,$this->Alias);

        $this->PassWord =new Property("Password","Password",PASSWORD,true,$this->Alias);

        $this->Name=new Property($this->Core->GetCode("Name"),"Name",TEXTBOX,false,$this->Alias);
        $this->FirstName=new Property($this->Core->GetCode("FirstName"),"FirstName",TEXTBOX,false,$this->Alias);
        $this->Sexe=new Property($this->Core->GetCode("Sexe"),"Sexe",NUMERICBOX,false,$this->Alias);
        $this->BirthDate=new Property($this->Core->GetCode("BirthDate"),"BirthDate",DATEBOX,false,$this->Alias);

        $this->CountryId=new Property("CountryId","CountryId",TEXTBOX,false,$this->Alias);
        //$this->Country=new EntityProperty($this->Core->GetCode("Country"),"CountryId",TEXTBOX,false,$this->Alias);

        $this->CityId=new Property("CityId","CityId",TEXTBOX,false,$this->Alias);
        $this->City=new EntityProperty("Core\Entity\City\City","CityId",TEXTBOX,false,$this->Alias);

        //Téléphone
        $this->Phone =new Property("Phone","Phone",TEXTBOX,false,$this->Alias);

        //Chemin de l'image
        $this->Image = new Property("Image","Image",IMAGE, false,$this->Alias);
        $this->ImageMini = new Property("ImageMini","ImageMini",IMAGE, false,$this->Alias);

        //Date de creation
        $this->DateCreate = new Property("DateCreate","DateCreate",DATEBOX, false,$this->Alias);
        $this->DateChange = new Property("DateChange","DateChange",DATEBOX, false,$this->Alias);

        //Url Du serveur de fichier
        $this->Serveur = new Property("Serveur","Serveur",TEXTBOX, false,$this->Alias);

        //Date de connection
        $this->DateConnect = new Property("DateConnect", "DateConnect", DATETIMEBOX, false,$this->Alias);

        //Identifiant facebook
        $this->FacebookId=new Property("FacebookId","FacebookId",TEXTBOX,false,$this->Alias);

        //Position dans le jeux
        $this->Position = new Property("Position","Position",TEXTBOX,false,$this->Alias);
        $this->Description = new Property("Description","Description",TEXTAREA,false,$this->Alias);

        //Creation de l'entit�
        $this->Create();
    }

    // Verification
    function Verify()
    {
            $User = new User($this->Core);
            $User->AddArgument(new Argument("User","Email",EQUAL,Request::GetPost("sourceControl")));
            $Users = $User->GetByArg();

            if(sizeof($Users) > 0)
            {
                    echo "False";
            }
            else
            {
                    echo "True";
            }
    }

    //Verifie si un utilisateur existe
    function Exist($userId ="")
    {
        $User = new User($this->Core);
        $User->AddArgument(new Argument("Core\Entity\User\User","Email",EQUAL,$this->Email->Value));

        if($userId != "")
        {
            $User->AddArgument(new Argument("Core\Entity\User\User","IdEntite",NOTEQUAL,$userId));
        }

        $Users = $User->GetByArg();

        if(sizeof($Users) > 0)
        {
            return true;
        }
        else
        {
            return false;
        }
    }

    /**
     * Modifie le mot de passe de l'utilisateur
     * */
    function ChangePassword($pass)
    {
            $request = " UPDATE ee_user SET PassWord='".md5($pass)."' ";
            $request .= " WHERE Id=". $this->IdEntite ;

            $this->Core->Db->Execute($request);
    }

    function GetNumber()
    {
       $user = $this->GetAll();
       return sizeof($user);
   }

   function GetInfo()
   {

   }

   /*
   * Récupere un utilisateur par son identifiant facebook
   */
	function GetByFacebookId($id)
	{
		$user= new User($this->Core);
		$user->AddArgument(new Argument("User","FacebookId",EQUAL, $id));
		$Users = $user->GetByArg();

		if(count($Users) > 0)
		{
			return $Users[0];
		}
		else
		{
			return null;
		}
	}

   	/**
   	 * Retourne le pseudo
   	 * ou le nom
   	 * */
   	function GetPseudo()
   	{
   		if($this->Pseudo->Value == "")
   		{
                    if($this->FirstName->Value != "")
                    {
                        return $this->FirstName->Value ." ".$this->Name->Value;
                    }
                    else
                     {
                        return $this->Email->Value;
                    }
   		}
   		else
   		{
			return $this->Pseudo->Value;
   		}
   	}

	/**
	 * Retourne une miniature de l'image
	 * */
	function GetImageMini()
	{
		if($this->Image->Value)
		{
			//Recuperation du nom du fichier
			return File::GetMini($this->Image->Value)."?".rand(0, 500);
		}
		else
		{
 			return '../Images/icones/nophoto.png';
		}
	}

	/**
	 * Initialise la date de connection
	 * POur le tchat
	 * */
	static function UpdateDateConnect($core, $userId)
	{
		$user = new User($core);
		$user->GetById($userId);
		$user->DateConnect->Value = JDate::Now(true);
		$user->Save();
	}

	/**
	 * Efface la date de connection
	 * */
    static function ClearDateConnect($core)
    {
    	$user = $core->User;
    	$user->DateConnect->Value = null;
		$user->Save();
	}

   	/**
   	 * Supprime le compte utilisateur
   	 *  */
   	 static function DeleteAccount($core, $userId)
   	 {
   	 	//par ordre alphabetique
   	 	//Commentaire
   	 	$request = "delete from ee_comment where userId=".$userId."";
		$core->Db->Execute($request);

		//Message multiple
		//Recuperation des messages
		$request = "select Id From ee_messages where FromId=".$userId." or ToId=".$userId."";
		$messages = $core->Db->GetArray($request);

		$in = "";

		if(sizeof($messages) > 0)
		{
			foreach($messages as $message)
			{
				if($in == "")
				{
					$in	.=$message["Id"];
				}
				else
				{
					$in	.= ",".$message["Id"];
				}
			}

		}

		$request = "delete from ee_messages_user where userId=".$userId." or MessageId in(".$in.")";
		$core->Db->Execute($request);

		//Message simple
		$request = "delete from ee_messages where FromId=".$userId." or ToId=".$userId."";
		$core->Db->Execute($request);

		//News
		$request ="select Id,Name from ee_file where userId=".$userId."";
		$files = $core->Db->GetArray($request);

		if(sizeof($files)> 0)
		{
			foreach($files as $file)
			{
				File::Delete($file["Name"], "../ImagesUser/User/User".$userId);
			}
		}

		//Suppression du repertoire
		File::DeleteDirectory("../ImagesUser/User/User".$userId);

		//Suppression de la photo
		File::Delete(md5("User".$userId).".jpeg","../ImagesUser/User");

		//Suppression en base
		$request = "delete from ee_file where userId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des news
		$request = "delete from ee_news where userId=".$userId."";
		$core->Db->Execute($request);

		//Recherches utilisateur
		//Suppression des résultats
		$request = "select Id from ee_searchs_user where userId=".$userId."";
		$searchs = $core->Db->GetArray($request);

		if(sizeof($searchs)>0)
		{
			foreach($searchs as $search)
			{
				$request = "delete from ee_searchs_user_result where SearchId=".$search["Id"]."";
				$core->Db->Execute($request);
			}
		}

		//Suppression des rechreches
		$request = "delete from ee_searchs_user where userId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des contact
		$request = "delete from ee_user_contact where userId=".$userId." or ContactId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des point d'interets
		$request = "delete from ee_user_interestpoint where userId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des notifications
		$request = "delete from ee_user_notify where userId=".$userId." or ContactId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des parametres
		$request = "delete from ee_user_parameter where userId=".$userId."";
		$core->Db->Execute($request);

		//Suppression des réponses
		$request = "delete from ee_user_response where userId=".$userId."";
		$core->Db->Execute($request);

		//Suppression de l'utilisateur
		$request = "delete from ee_user where Id=".$userId."";
		$core->Db->Execute($request);

		Request::Disconnect($core);
		$core->Redirect("index.php");
   	 }

	 /**
	  * Recherche de membre
	  * */
   	 public function SearchUser($name ='', $firstName ='', $email ='')
   	 {
   	 	if($name != '')
   	 	{
			$request = "  SELECT Id FROM `ee_user` WHERE (Name like '".$name."%'";
			$request .= " OR FirstName like '".$firstName."%' ";
			$request .= " OR Email = '".$email."' ) ";

			//$request .= " AND Id <>".$this->Core->User->IdEntite;
   	 	}
   	 	else
   	 	{
			$request = "  SELECT Id FROM `ee_user` WHERE (Name like '".Format::EscapeString(Request::GetPost("sourceControl"))."%'";
			$request .= " OR FirstName like '".Format::EscapeString(Request::GetPost("sourceControl"))."%' )";
			//$request .= " AND Id <>".$this->Core->User->IdEntite;
	   	}

                //TODO Faire la jointure sur les user qui ne sont pas encore dans mes contacts
		$results = $this->Core->Db->GetArray($request);

		if(sizeof($results) > 0)
		{
			$TextControl = "<dt style='width:200px;text-align:left;'>";

			foreach($results as $result)
			{
				//Reccuperation des informations du membre
				$user = new User($this->Core);
				$user->GetById($result["Id"]);

				$TextControl .= "<dl>";

				//Affichage de l'image en mini
				$imgUser = new Image($user->GetImageMini());
				$imgUser->AddStyle("width","50px");

				//Ajout d'une case a cocher pour envoyer des invitations
				$cbUser = new CheckBox($result["Id"]);
                                $cbUser->Name = $user->GetPseudo();

				$TextControl .= $cbUser->Show().$imgUser->Show().$user->GetPseudo();

				$TextControl .= "</dl>";
			}

			$TextControl .= "<dt>";

			//Bouton d'invitation
			$btnSend = new Button(BUTTON);
			$btnSend->Value = $this->Core->GetCode("Ajouter");
			$btnSend->CssClass = "btn btn-success";
			$btnSend->AddStyle('width','150px');

                        if(Request::GetPost("AddAction"))
                        {
                		$btnSend->OnClick = Request::GetPost("AddAction");
		        }

			//TODO ajouter une methode pour définir la fonction a appeler
			else if($name != '')
			{
				$btnSend->OnClick = "EeContactAction.AddInvitation();";
			}
			else
			{
				$btnSend->OnClick = "ContactsBlock.AddInvitation();";
			}
			$TextControl .= "<br/>".$btnSend->Show();


			//Fermeture de la div pour l'appli EeContact'
			if($name != '')
			{
				$btnClose = new Button(BUTTON);
				$btnClose->Value = $this->Core->GetCode("Close");
				$btnClose->AddStyle('width','150px');
				$btnClose->OnClick = "EeContactAction.CloseInfo();";
				$TextControl .= $btnClose->Show();

			}

		}
		else
		{
			$TextControl = "<span  class='FormUserError''>".$this->Core->GetCode("NoMember")."</span>";
		}

		$TextControl .= "<br/>";
		echo $TextControl;
   	 }
}

/**
 * Groupe de utilisateur
 * */
 class UserGroup extends Entity
 {
 	protected $User;

	function UserGroup($core)
	{
		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_user_group";
		$this->Alias = "usgr" ;

		//Utilisateur
		$this->UserId = new Property("UserId","UserId",TEXTBOX, true,$this->Alias);
		$this->User = new EntityProperty("User","UserId");

		//Type de news
		$this->Name = new Property("Name","Name",TEXTBOX, false, $this->Alias);

		//Creation de l'entit�
		$this->Create();
	}
 }

/**
 * Membre des groupe
 * */
class UserGroupUser extends Entity
 {
 	protected $User;
 	protected $Group;

	function UserGroupUser($core)
	{
		//Nom de la table
		$this->Core=$core;
		$this->TableName="ee_user_groupuser";
		$this->Alias = "usgrus" ;

		//Group
		$this->GroupId = new Property("GroupId","GroupId",TEXTBOX, true,$this->Alias);
		$this->Group = new EntityProperty("UserGroup","GroupId");

		//Utilisateur
		$this->UserId = new Property("UserId","UserId",TEXTBOX, true,$this->Alias);
		$this->User = new EntityProperty("User","UserId");

		//Creation de l'entit�
		$this->Create();
	}

	static function MemberExist($core, $groupId, $userId)
	{
		$request ="SELECT Id FROM ee_user_groupuser WHERE GroupId=".$groupId;
		$request .= " AND UserId = ".$userId;

		$result = $core->Db->GetLine($request);
		return $result["Id"] != "";
	}
 }

?>
