var Devis = function() {};

	/*
	* Chargement de l'application
	*/
	Devis.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Devis.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Devis.Execute, "", "Devis");
		Dashboard.AddEventWindowsTool("Devis");
                
               DevisAction.LoadMyProjet();
	};

   /*
	* Execute une fonction
	*/
	Devis.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Devis");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Devis.Comment = function()
	{
		Dashboard.Comment("Devis", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Devis.About = function()
	{
		Dashboard.About("Devis");
	};

	/*
	*	Affichage de l'aide
	*/
	Devis.Help = function()
	{
		Dashboard.OpenBrowser("Devis","{$BaseUrl}/Help-App-Devis.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Devis.ReportBug = function()
	{
		Dashboard.ReportBug("Devis");
	};

	/*
	* Fermeture
	*/
	Devis.Quit = function()
	{
		Dashboard.CloseApp("","Devis");
	};
        
        /*
         * Evenements
         */
        DevisAction = function(){};
        
        /**
         * Pop in d'ajout d'un projet 
         * @returns {undefined}
         */
        DevisAction.ShowAddProjet = function()
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAddProjet';
              
                Dashboard.OpenPopUp('Devis','ShowAddProjet', '','','', 'DevisAction.LoadMyProjet()', serialization.Encode(param));
        
                Dashboard.SetBasicAdvancedText("tbDescription");
        };
        
        /*
         * Charge les projets de devis
         */
        DevisAction.LoadMyProjet = function()
        {
            var data = "Class=Devis&Methode=LoadMyProjet&App=Devis";
            Dashboard.LoadControl("dvDesktop", data, "" , "div", "Devis"); 
        };
        
        /**
         * Charge les projet de devis
         * @returns {undefined}
         */
        DevisAction.LoadProjet = function(projetId)
        {
         var data = "Class=Devis&Methode=LoadProjet&App=Devis";
              data += "&projetId=" + projetId ;
              Dashboard.LoadControl("dvDesktop", data, "" , "div", "Devis"); 
              
              DevisAction.Tab = new Array();
              
              //Memorisation du cms
              DevisAction.ProjetId = projetId;
              
              Dashboard.SetBasicAdvancedText("tbDescription");
        };
        
        /*
         * Pop in d'ajout de catégorie
         */
        DevisAction.ShowAddCategory = function(projetId, categoryId)
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAddCategory';
                param['projetId'] = projetId;
                
                if(categoryId != undefined)
                {
                    param['categoryId'] = categoryId;
                }
                
                Dashboard.OpenPopUp('Devis','ShowAddCategory', '','','', 'DevisAction.RefreshCategory('+projetId+')', serialization.Encode(param));
        
                Dashboard.SetBasicAdvancedText("tbCategoryDescription");
        };
        
         /**
         * Recharge les catégories du forum
         **/
        DevisAction.RefreshCategory = function(projetId)
        {
           var data = "Class=Devis&Methode=RefreshCategory&App=Devis";
               data += "&projetId=" + projetId;
           
               Dashboard.LoadControl("tab_1", data, "" , "div", "Devis"); 
        };
        
        /**
         * Supprimer une catégorie Si il n'y a pas de prestation attaché et de devis
         * @returns {undefined}
         */
        DevisAction.DeleteCategory = function(control, categoryId)
        {
            if(Dashboard.Confirm("delete"))
            {
                           
            //Sauvagarde ajax
            var JAjax = new ajax();
                JAjax.data = "App=Devis&Methode=DeleteCategory";
                JAjax.data += "&categoryId=" + categoryId;
  
               result = JAjax.GetRequest("Ajax.php");
                
                if(result.indexOf("1") > -1)
                {
                    control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
                }   
            }
        };
        
         /*
         * Pop in d'ajout de prestation
         */
        DevisAction.ShowAddPrestation = function(categoryId, prestationId)
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAddPrestation';
                param['categoryId'] = categoryId;
                
                if(prestationId != undefined)
                {
                    param['prestationId'] = prestationId;
                }
                
                Dashboard.OpenPopUp('Devis','ShowAddPrestation', '','','', 'DevisAction.RefreshPrestation('+categoryId+')', serialization.Encode(param));
                Dashboard.SetBasicAdvancedText("tbPrestationDescription");
        };
        
        /*
         * Rafraichit les prestations des catégories
         */
        DevisAction.RefreshPrestation = function(categoryId)
        {
            var lstPrestation = document.getElementById("lstPrestation"+categoryId);
            
             //Sauvagarde ajax
            var JAjax = new ajax();
                JAjax.data = "App=Devis&Methode=RefreshPrestation";
                JAjax.data += "&categoryId=" + categoryId;
  
               lstPrestation.innerHTML = JAjax.GetRequest("Ajax.php");
        };
        
        /*
         * Pop in de demande de devis 
         * pour un projet et une prestation
         */
        DevisAction.AskDevis = function(prestationId )
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAskDevis';
                param['prestationId'] = prestationId;
              
                Dashboard.OpenPopUp('Devis','ShowAskDevis', '','','', '', serialization.Encode(param));
                Dashboard.SetBasicAdvancedText("tbDevisDescription");
        };
        
        /*
         * Pop in du detail d'un devis
         */
        DevisAction.EditAsk = function(askId)
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'Devis.DetailAsk';
                param['askId'] = askId;
              
                Dashboard.OpenPopUp('Devis','EditAsk', '','','', '', serialization.Encode(param));
        };
        
        /*
         * Pop in d'ajout d'un modee de devis 
         */
        DevisAction.ShowAddModele = function(projetId, devisId)
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAddModele';
                param['projetId'] = projetId;
                param['devisId'] = devisId;
              
                Dashboard.OpenPopUp('Devis','ShowAddModele', '','','', "DevisAction.RefreshTabModele("+projetId+");", serialization.Encode(param));
        };
        
        /*
         * Rafrachissement des modelededevis
         * @returns {undefined}
         */
        DevisAction.RefreshTabModele = function(projetId)
        {
            DevisAction.RefreshTab(projetId, "tab_1", "ProjetBlock" , "GetTabModele");
        };
        
        /*
         * Rafrachissement des devis
         * @returns {undefined}
         */
        DevisAction.RefreshTabDevis = function(projetId)
        {
            DevisAction.RefreshTab(projetId, "tab_4", "ProjetBlock" , "GetTabDevis");
        };
        
        /**
         * Rafrachit le contenu d'un onlget
         * @param {type} proetId
         * @param {type} tab
         * @param {type} block
         * @returns {undefined}
         */
        DevisAction.RefreshTab=function(projetId, tab, block, action)
        {
                 var data = "Class=Devis&Methode=RefreshTab&App=Devis";
                     data += "&ProjetId="+ projetId;
                     data += "&Block="+ block;
                     data += "&Action=" + action;
               
               Dashboard.LoadControl(tab, data, "" , "div", "Devis");
        };
        
        /*
         * Pop in d'ajout d'un devis 
         */
        DevisAction.ShowAddDevis = function(projetId, devisId)
        {
            var param = Array();
                param['App'] = 'Devis';
                param['Title'] = 'EeProjet.ShowAddDevis';
                param['projetId'] = projetId;
                
                if(devisId != undefined)
                {
                    param['devisId'] = devisId;
                }
                
                Dashboard.OpenPopUp('Devis','ShowAddDevis', '','','', "DevisAction.RefreshTabDevis("+projetId+");", serialization.Encode(param));
        
                 //DevisAction.InitChange();
            $(".number").change(function ()
            {
                DevisAction.CalculateSubTotal(this);
            });
            $(".price").change(function ()
            {
                DevisAction.CalculateSubTotal(this);
            });
            
            DevisAction.CalculateTotal();
        };
        
        /**
         * Ajoute une ligne a la facture
         * @param {type} devisId
         * @returns {undefined}
         */
        DevisAction.AddLine = function(cell, devisId)
        {
            var tabLine = document.getElementById("tabLine");
            
            var tbPrestation = document.getElementById("tbPrestation");
            var tbNbr = document.getElementById("tbNbr");
            var tbPrice = document.getElementById("tbPrice");
        
            //Ajout de la ligne
            html = "<td><input type='text' value='"+tbPrestation.value+"'></td>";
            html += "<td><input type='text' class='number' value='"+tbNbr.value+"'></td>";
            html += "<td><input type='text' class='price' value='"+tbPrice.value+"'></td>";
            html += "<td><input type='text' class='subTotal' disabled='disabled' value='"+ ( tbNbr.value * tbPrice.value  )+"'></td>";
            
            var newLine = document.createElement("tr");
            newLine.innerHTML = html;
            
            tabLine.appendChild(newLine);
         
            //DevisAction.InitChange();
            $(".number").change(function ()
            {
                DevisAction.CalculateSubTotal(this);
            });
            $(".price").change(function ()
            {
                DevisAction.CalculateSubTotal(this);
            });
            
            DevisAction.CalculateTotal();
            
            tbPrestation.value = "";
            tbNbr.value = "";
            tbPrice.value = "";
        };
        
        /*
         * Calcul le sous total d'une ligne
         * @returns {undefined}
         */
        DevisAction.CalculateSubTotal = function(control)
        {
            line = control.parentNode.parentNode;
            inputs = line.getElementsByTagName("input");
            
            //Mise a jour du sous total
            inputs[3].value = inputs[1].value * inputs[2].value;
            
            DevisAction.CalculateTotal();
        };
        
        /*
         * Calcul le total
         */
        DevisAction.CalculateTotal = function()
        {
            var total = 0;
            
            $(".subTotal").each(function (){
                
                total += parseInt(this.value);
            });
            
            $("#tbTotal").val(total);
        };
        
        /*
         * Sauvegarde le devis complet
         */
        DevisAction.SaveDevis = function(projetId, devisId)
        {
            //Recuperation des elements
            var number = document.getElementById("Number").value;
            var InformationSociete = document.getElementById("InformationSociete").value;
            var InformationClient = document.getElementById("InformationClient").value;
            var DateCreated = document.getElementById("DateCreated").value;
            var DatePaiment = document.getElementById("DatePaiment").value;
            var TypePaiment = document.getElementById("TypePaiment").value;
            var InformationComplementaire = document.getElementById("InformationComplementaire").value;
            
            //Recuperation des lignes
            var tab = document.getElementById("tabLine");
            var tabLines = tab.getElementsByTagName("tr");
            var lines = Array();
            
            for(i=0; i< tabLines.length; i++)
            {
                inputs = tabLines[i].getElementsByTagName("input");
                
                lines.push(inputs[0].value + ":" + inputs[1].value + ":" + inputs[2].value + ":" + inputs[3].value);
            }
        
            //Sauvegarde
            var JAjax = new ajax();
                JAjax.data = "App=Devis&Methode=SaveDevis";
                JAjax.data += "&projetId=" + projetId;
                if(devisId != undefined)
                {    
                    JAjax.data += "&devisId=" + devisId;
                }
                JAjax.data += "&number=" + number;
                JAjax.data += "&InformationSociete=" + InformationSociete;
                JAjax.data += "&InformationClient=" + InformationClient;
                JAjax.data += "&dateCreated=" + DateCreated;
                JAjax.data += "&datePaiment=" + DatePaiment;
                JAjax.data += "&typePaiment=" + TypePaiment;
                JAjax.data += "&informationComplementaire=" + InformationComplementaire;
                JAjax.data += "&lines=" + lines.join("||");
               
                alert(JAjax.GetRequest("Ajax.php"));
        };
        
        /**
         * Sauvegarde le devis au format PDF
         * @param {type} control
         * @param {type} devisId
         * @returns {undefined}
         */
        DevisAction.SaveAsPdf = function(control, devisId)
        {
            var JAjax = new ajax();
                JAjax.data = "App=Devis&Methode=SaveAsPdf";
                JAjax.data += "&devisId=" + devisId;
                
                JAjax.data += "&content="+document.getElementById("dvDevis").innerHTML;
                
                JAjax.GetRequest("Ajax.php");
        };