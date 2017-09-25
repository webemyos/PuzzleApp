<?php

/*
 * PuzzleApp
 * Webemyos
 * Jérôme Oliva
 * GNU Licence
 */

namespace Core\Block\ContactBlock;

use Core\Core\Core;
use Core\Core\Request;
use Core\Block\Block;
use Core\Block\IBlock;
use Core\Block\FormBlock\FormBlock;
use Core\Control\TextBox\TextBox;
use Core\Control\EmailBox\EmailBox;
use Core\Control\TextArea\TextArea;
use Core\Control\Button\Button;
use Core\Action\UserAction\UserAction;

class ContactBlock extends Block implements IBlock
{
	// Propriété
	private $EditMode;

	//Constructeur
	function __construct($core="", $editMode=SIMPLE)
	{
		//Version
 		$this->Version = "2.2.0.0";

		$this->Core= Core::getinstance();
                $this->Id = "ContactBlock";
		$this->Table = false;
		$this->Frame = false;
		$this->Send = false;
		$this->Error = false;

		$this->EditMode = $editMode;

		// Formulaire de contact
		$this->FormContact = new FormBlock("formContact","",POST,"Page", $this->Core);
		$this->FormContact->Table = false;
		$this->FormContact->Frame = false;

		//Champs de saisie
		$this->tbName = new TextBox("tbName");
		$this->tbName->Libelle = '';
		$this->tbName->PlaceHolder = "'".$this->Core->GetCode("YourName")."'";
		$this->tbName->AddStyle("Width" , "250px");
		//$this->tbFirstName = new TextBox("tbFirstName");
		$this->tbEmail = new EmailBox("tbEmail");
		$this->tbEmail->Libelle = '';
		$this->tbEmail->AddStyle("Width" , "250px");
		$this->tbEmail->PlaceHolder = "'".$this->Core->GetCode("YourEmail")."'";
		//$this->tbPhone = new TextBox("tbPhone");
		//$this->tbPhone->Libelle = "Phone";
		$this->tbMessage = new TextArea("tbMessage");
		$this->tbMessage->AddStyle("Width" , "250px");
		$this->tbMessage->Libelle = '';
                $this->tbMessage->Value = "";
		$this->tbMessage->PlaceHolder = "'".$this->Core->GetCode("YourMessage")."'";

		if($editMode != ADVANCED)
		{
			//$this->tbName->Libelle = "YourName";
			//$this->tbFirstName->Libelle = "YourFirstName";
		}
		else
		{
			$this->FormContact->Add(new libelle($this->Core->GetCode("PreciseNature")),"2");

			$RbInfo = new RadioButton("rbNature");
			$RbInfo->Value ="0";
			$RbInfo->Libelle = "AskInformation";
			$this->FormContact->AddNew($RbInfo);

			$RbDevis = new RadioButton("rbNature");
			$RbDevis->Value ="1";
			$RbDevis->Libelle = "AskDevis";
			$this->FormContact->AddNew($RbDevis);

			$RbPartenariat = new RadioButton("rbNature");
			$RbPartenariat->Value ="2";
			$RbPartenariat->Libelle = "AskPartenariat";
			$this->FormContact->AddNew($RbPartenariat);

			$RbOther = new RadioButton("rbNature");
			$RbOther->Value ="2";
			$RbOther->Libelle = "AskOther";
			$this->FormContact->AddNew($RbOther);

			$this->tbName->Libelle = "YourSocieteName";
			$this->tbFirstName->Libelle = "YourNameAndFirstName";
		}

		//Ajout des controles au formulaire
		//$this->FormContact->AddNew(new Libelle("<span class='required'>*</span>"));
		$this->FormContact->Add($this->tbName);

		//$this->FormContact->AddNew($this->tbFirstName);
		//$this->FormContact->Add(new Libelle("*"));

		if($editMode == ADVANCED)
		{
			$this->tbFonction = new TextBox("tbFonction");
			$this->tbFonction->Libelle = "YourFonction";
			$this->FormContact->AddNew($this->tbFonction);
		}

		//$this->FormContact->Add(new Libelle("<span class='required'>*</span>"));
		$this->FormContact->AddNew($this->tbEmail);

		//$this->FormContact->AddNew($this->tbPhone);
		$this->FormContact->AddNew($this->tbMessage);

		// Bouton d'envoi
		$this->btnSend = new Button(BUTTON);
		$this->btnSend->CssClass = "btn btn-success";
		$this->btnSend->Value = $this->Core->GetCode("Send");
		$this->btnSend->OnClick = new UserAction("SendMessage");

		$this->FormContact->AddNew($this->btnSend,"2",ALIGNRIGHT);
	}

	//Envoi du message
	function SendMessage()
	{

		if(	Request::GetPost("tbName") != ""
			/*&& JVar::GetPost("tbFirstName") != ""*/
			&& Request::GetPost("tbEmail") != ""
			&&  $this->tbEmail->Verify()
		)
		{
			$Email  = new JEmail();
			$Email->Template = "MessageTemplate";
			$Email->Sender = JVar::GetPost("tbEmail");
			$Email->Title = "Demande de contact Webemyos";

			if($this->EditMode != ADVANCED)
			{
				$Email->Body = Request::GetPost("tbName")." " ;
				/*$Email->Body .= JVar::GetPost("tbFirstName");*/
				$Email->Body .= " a envoyé un message <br/>";
				$Email->Body .= "<br/> Son email est  : ".JVar::GetPost("tbEmail");
				/*$Email->Body .= "<br/>Son télephone est  : ".JVar::GetPost("tbPhone");*/
				$Email->Body .= "<br/> Voici son message :";
				$Email->Body .= Request::GetPost("tbMessage");
			}
			else
			{
				$Email->Body = Request::GetPost("tbFirstName")." pour la société " ;
				$Email->Body .= Request::GetPost("tbFirstName");
				$Email->Body .= "<br/> a envoyé un message ";

				switch(Request::GetPost("rbNature"))
				{
					case 0:
						$nature = "Demande d'information";
					break;
					case 1:
						$nature = "Demande de devis";
					break;
					case 2:
						$nature = "Demande de partenariat";
					break;
					case 3:
						$nature ="Autre";
					break;
				}

				$Email->Body .= "<br/> Pour un demande de nature : ".$nature;
				$Email->Body .= "<br/> Son email est  : ".Request::GetPost("tbEmail");
				$Email->Body .= "<br/> Son télephone est  : ".Request::GetPost("tbPhone");
				$Email->Body .= "<br/> Son fonction est  : ".Request::GetPost("tbFonction");
				$Email->Body .= "<br/> Voici son message :";

				$Email->Body .= Request::GetPost("tbMessage");
			}

			$Email->SendToAdmin();
			$this->Send = true;
		}
		else
		{
			$this->Error = true;
		}
	}

	//Initialisation
	function Init()
	{

	}

	//Insertion des controls
	function Create()
	{
		if($this->Send)
		{
			$this->Body = '<span class="success">'.$this->Core->GetCode("MessageSendOK").'</span>';
		}
		else if($this->Error)
		{
			$this->Body = '<br/><span class="error">'.$this->Core->GetCode("MessageFieldEmpty").'</span>';
                        $this->Body .= $this->FormContact->Show();
                }
                else
                {
                        $this->Body .= $this->FormContact->Show();
                }
	}

	//Affichage
	function Show()
	{
		$this->LoadControl();
		$this->CallMethod();
		$this->Init();
		$this->Create();
		return parent::Show();
	}

	//Asseceur
	public function __get($name)
	{
		return $this->$name;
	}

	public function __set($name,$value)
	{
            $this->$name=$value;
	}
}
?>
