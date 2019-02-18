var Ide = function() {};

/*
* Chargement de l'application
*/
Ide.Load = function(parameter)
{
    this.LoadEvent();
    //TODO TROUVER UNE SOLUTION POUR CHARGER TOUS LES SCRIPTS  
    // Ide.LoadJsApp();
};

/**
 * Charge les js des applications
 * @returns {undefined}
 */
Ide.LoadJsApp = function()
{
    var apps = Array("IdeElement", "IdeTool", "IdeInsert");

    for(i=0 ; i< apps.length ; i++)
    {
        var name = apps[i];
        Ide.IncludeJs(name + ".js");
    }  
};

/*
* Chargement des �venements
*/
Ide.LoadEvent = function()
{
        Dashboard.AddEventAppMenu(Ide.Execute, "", "Ide");
        Dashboard.AddEventWindowsTool("Ide");
};

/*
* Execute une fonction
*/
Ide.Execute = function(e)
{
        //Appel de la fonction
        Dashboard.Execute(this, e, "Ide");
        return false;
};

/*
 * Charge la page d'accueil
 */
Ide.LoadHome = function()
{
    var data = "Class=Ide&Methode=LoadHome&App=Ide";
    Dashboard.LoadControl("appCenter", data, "" , "div", "Ide");
};

/*
* Inclu le fichier javascript
*/
Ide.IncludeJs = function(file)
{
     //TODO verifier que les script n'a pas déjà été ajouté
    var script = document.createElement('script');
    script.setAttribute('type','text/javascript');
    script.setAttribute('src', "../Apps/Ide/" + file);

    document.body.appendChild(script);
};

/**
 * Creation d'un nouveau projet
 **/
Ide.NewProjet = function()
{
 var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.NewProjet';
    
    Dashboard.OpenPopUp('Ide','ShowCreateNewProjet', '','','', 'IdeAction.LoadUserProjet()', serialization.Encode(param));
};

/**
 * Popin d'ajout de fonction javascript
 * @returns 
 */
Ide.ShowInsertJs= function()
{
    var param = Array();
        param['App'] = 'Ide';
        param['Title'] = 'InsertJs';

        Dashboard.OpenPopUp('Ide','ShowInsertJs', '','','', '', serialization.Encode(param));
};

/**
 * Popin d'ajout de fonction php
 * @returns 
 */
Ide.ShowInsertPhp= function()
{
    var param = Array();
        param['App'] = 'Ide';
        param['Title'] = 'InsertPhp';

        Dashboard.OpenPopUp('Ide','ShowInsertPhp', '','','', '', serialization.Encode(param));
};

/*
*	Affichage de commentaire
*/
Ide.Comment = function()
{
    Dashboard.Comment("Ide", "1");
};

/*
*	Affichage de a propos
*/
Ide.About = function()
{
    Dashboard.About("Ide");
};

/*
*	Affichage de l'aide
*/
Ide.Help = function()
{
        Dashboard.OpenBrowser("Ide","{$BaseUrl}/Help-App-Ide.html");
};

/*
*	Affichage de report de bug
*/
Ide.ReportBug = function()
{
        Dashboard.ReportBug("Ide");
};

/*
* Fermeture
*/
Ide.Quit = function()
{
        Dashboard.CloseApp("","Ide");
};


/**
 * Evenements
 */
IdeAction = function(){};

/**
 * Creation d'un nouveau projet
 */
IdeAction.NewProjet = function()
{
    Ide.NewProjet();
};

/**
 * Rafraichit la liste des projets de l'utilisateur
 */
IdeAction.LoadUserProjet = function()
{
    var data = "Class=Ide&Methode=LoadUserProjet&App=Ide";
    Dashboard.LoadControl("lstProjet", data, "" , "div", "Ide");
};

/**
 * Charge un projet complet
 */
IdeAction.LoadProjet = function(projet)
{
    //Memorisation du projet
    Ide.Projet = projet;
    
    var data = "Class=Ide&Methode=LoadProjet&App=Ide&Projet="+projet;
    Dashboard.LoadControl("appCenter", data, "" , "div", "Ide");
};

var IdeElement = function(){};

/**
 * Charge un fichier dans l'editeur
 */
IdeElement.LoadFile = function(name, module, helper)
{
    //Recuperation du tabStrip
    var tsFile = document.getElementById("tsEditor");
    var th = tsFile.getElementsByTagName("th");

    //Recuperation du dernier onglet
    var lastTab = th[th.length-1];

    var idTab = lastTab.id.split("_");
    var id = idTab[1];
    id++;

    var newTab = document.createElement("th");

    //Image de fermeturue
    if(typeof(module) != 'undefined' && module != "")
    {
        fileName = name + "Module:" + module;
    }
    else if(typeof(helper) != 'undefined')
    {
         fileName = name + "Helper:" + helper; 
    }
    else
    {
        fileName = name;
    }
    newTab.innerHTML = fileName  ;
    newTab.name = name ;
    newTab.id = "index_" + id;
    newTab.className = "TabStripDisabled";
    newTab.title = fileName ;
    var click = function(){ TabStrip.ShowTab(this,'tab_'+id+'',id);};

    Dashboard.AddEvent(newTab, "click", click);

    //Ajout de l'onglet
    (th[0]).parentNode.appendChild(newTab);

    //Recuperation de la div center pour ajuster la taille
    var fsCenter = Dashboard.GetElement("appCenter","div","Ide");

    //Ajout de la div correspondante
    var div = document.createElement("div");
    div.id = "tab_"+id+"";
    div.style.overflow = 'hidden';
    div.style.display = 'none';
    //div.style.width = fsCenter.style.width;
    //div.style.height = fsCenter.style.height;

    div.innerHTML = "Loading ...";
    var JAjax = new ajax();
       JAjax.data = "App=Ide&Methode=LoadFile";
       JAjax.data += "&Name=" + fileName;
       JAjax.data += "&Projet=" + Ide.Projet;
       
    if(typeof(module) != 'undefined')
    {  
       JAjax.data += "&Module=" + module;
    }
    
    if(typeof(helper) != 'undefined')
    {
        JAjax.data += "&Helper=" + helper;
    }
   
    var contenu = "<textarea  id='tb_"+id+"'>";
    contenu += JAjax.GetRequest("Ajax.php");
    contenu += "</textarea>";

    div.innerHTML = contenu;

    tsFile.appendChild(div);

    TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Ide");
};

/**
 * Pop up d'ajout de module
 */
IdeElement.ShowAddModule = function()
{
   var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.NewModule';
    param['Projet'] = Ide.Projet;
    
    Dashboard.OpenPopUp('Ide','ShowAddModule', '','','', 'IdeElement.LoadRefreshModule()', serialization.Encode(param));
};

/**
 * Permet d'editer un module 
 * @returns 
 */
IdeElement.AddActionModule = function(block)
{
    var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.AddAction';
    param['Projet'] = Ide.Projet;
    param['Block'] = block;
    
    Dashboard.OpenPopUp('Ide','ShowAddActionModule', '','','', '', serialization.Encode(param));
};

/**
 * Charge le code d'un module
 * @returns 
 */
IdeElement.LoadCodeModule = function(module)
{
    IdeElement.LoadFile("", module);
};

/**
 * Rafrachit les modules du projet
 * @returns {undefined}
 */
IdeElement.LoadRefreshModule = function()
{
    var data = "Class=Ide&Methode=LoadModule&App=Ide&Projet=" +  Ide.Projet;
    Dashboard.LoadControl("lstBlock", data, "" , "div", "Ide");
};

/**
 * Pop in d'ajout d'une entité
 * @returns 
 */
IdeElement.ShowAddEntity = function()
{
var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.NewEntity';
    param['Projet'] = Ide.Projet;
    
    Dashboard.OpenPopUp('Ide','ShowAddEntity', '','','', 'IdeElement.LoadRefreshEntity()', serialization.Encode(param));
};       

/**
 * Supprime une entité
 * @returns 
 */
IdeElement.DeleteEntity = function(name)
{
    var JAjax = new ajax();
        JAjax.data = "CLass=Ideik N&App=Ide&Methode=DeleteEntitlhhg;y";
        JAjax.data = "&Projet=" + Ide.Projet;
        JAjax.data += "&Name=" + name;
             
     //Execution
     JAjax.GetRequest("Ajax.php");
    
     IdeElement.LoadRefreshEntity();
};

/**
 * Ouvre ou ferme un table
 * */
IdeElement.ShowTableElement = function(table)
{
    var tb = document.getElementById(table);
    
    if(tb.style.display == 'none')
    {
        $("#"+table).show();
    }
    else
    { 
        $("#"+table).hide();
    }
};

/**
 * Ajoute une ligne de champ
 * @returns 
 */
IdeElement.AddField = function(table)
{
     var tb = document.getElementById(table);
     
     var ligne = document.createElement("tr");
     
    ligne.innerHTML = "<td><input type='text'></input></td>";
    ligne.innerHTML += "<td><select><option value='0'>Int</option><option value='1'>Varchar(50)</option><option value='2'>Text</option><option value='3'>Date</option></select></td>";
    ligne.innerHTML += "<td><input type='checkbox' /></td>";
    ligne.innerHTML += "<td><i class='icon-remove' onclick='IdeElement.RemoveField(this)' />&nbsp;</i></td>";
    
    tb.appendChild(ligne); 
};


/**
 * Supprime un champ
 * @param {type} control
 * @returns {undefined}
 */
IdeElement.RemoveField = function(control)
{
    control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
};

/**
 * Ajout une ligne pour les clés
 * @returns 
 */
IdeElement.AddKey = function(table)
{
     var tb = document.getElementById(table);
    
     var ligne = document.createElement("tr");
    
    ligne.innerHTML = "<td><input type='text'></input></td>";
    ligne.innerHTML += "<td><input type='text' /></td>";
    ligne.innerHTML += "<td><input type='text' /></td>";
    ligne.innerHTML += "<td><i class='icon-remove' onclick='IdeElement.RemoveKey(this)' />&nbsp;</i></td>";
         
         tb.appendChild(ligne);
};

/**
 * Supprime une clé
 * @param {type} control
 * @returns {undefined}
 */
IdeElement.RemoveKey = function(control)
{
    control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
};

/**
 * 
 * @returns {undefined}Crée une entite
 */
IdeElement.CreateEntity = function()
{
    //Recuperation des controls
    var dvResult = document.getElementById("dvResultEntity");
    var tbNameEntity = document.getElementById("tbNameEntity");
    var cbShared = document.getElementById("cbShared");
    
     //Recuperation des champs
     var taField = document.getElementById("taField");
     var rows = taField.getElementsByTagName("tr");
     var Fields = Array();
     
     for( i=1; i < rows.length; i++ )
     {
         var inputs = rows[i].getElementsByTagName("input");
         var select = rows[i].getElementsByTagName("select");
         
         if(inputs.length > 0)
         {
             Fields.push(inputs[0].value + "-_" + select[0].value + "-_" + inputs[1].checked);
        }
     }
     
     //Recuperation des clés
     var taKey = document.getElementById("taKey");
     var rows = taKey.getElementsByTagName("tr");
     var Keys = Array();
     
     for( i=1; i < rows.length; i++ )
     {
         var inputs = rows[i].getElementsByTagName("input");
         
         if(inputs.length > 0)
         {
             Keys.push(inputs[0].value + "-_" + inputs[1].value + "-_" + inputs[2].value);
        }
     }
     
      //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=Ide&Methode=CreateEntity";
       JAjax.data += "&Name=" + tbNameEntity.value;
       
       if(cbShared.checked)
       {
            JAjax.data += "&Shared=" + cbShared.checked;
       }
    
       JAjax.data += "&Projet=" + Ide.Projet;
       JAjax.data += "&Fields=" + Fields.join("!!");
       JAjax.data += "&Keys=" + Keys.join("!!");
             
     //Execution
     dvResult.innerHTML = JAjax.GetRequest("Ajax.php");
};

/*
 *Rafrachit le liste des entites 
 */
IdeElement.LoadRefreshEntity  = function()
{
    var data = "Class=Ide&Methode=LoadEntity&App=Ide&Projet=" +  Ide.Projet;
    Dashboard.LoadControl("lstEntity", data, "" , "div", "Ide");
};

/**
 * 
 * @param {type} entity
 * @returns {undefined}Affiche les donnée de l'entite
 */
IdeElement.ShowData = function(entity)
{
    var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.ShowDate';
    param['Projet'] = Ide.Projet;
    param['Entity'] = entity;
    
    Dashboard.OpenPopUp('Ide','ShowDataEntity', '','','', 'IdeElement.LoadRefreshEntity()', serialization.Encode(param));
};

/**
 * Affiche le template d'un module
 * @param module
 * @returns 
 */
IdeElement.LoadTemplate = function(module)
{
var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.ShowDate';
    param['Projet'] = Ide.Projet;
    param['Module'] = module;
    param['Top'] = "10px";
    param['Left'] = "10px";
    
    //Ajoute le fichier css
    //Rajouter le nouveau fichier css
  //  IdeElement.RemoveJs("../Apps/" + Ide.Projet + "/" + Ide.Projet + ".css");
  //  IdeElement.IncludeJs("../Apps/" + Ide.Projet + "/" + Ide.Projet + ".css");
    
    Dashboard.OpenPopUp('Ide','ShowTemplate', '', '1000', '600', '', serialization.Encode(param));
};

/**
 * Charge le template dans l'editeur et dans le navigateur
 */
IdeElement.LoadCodeTemplate = function( projet, module, file, all)
{
    //Recuperation des controles
    var IdeTemplateEditor = document.getElementById("IdeTemplateEditor");
    var IdeBrowser = document.getElementById("IdeBrowser");
        
    Ide.Projet = projet;
    Ide.Module = module;
    Ide.File = file;
    
    //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=Ide&Methode=LoadCodeTemplate";
       JAjax.data += "&Projet=" + projet;
       JAjax.data += "&Module=" + module;
       JAjax.data += "&File=" + file;
       
      content = JAjax.GetRequest("Ajax.php");
      
      if(all == true)
      {
        IdeTemplateEditor.innerHTML = "<textarea id='tbCodeTemplate'>" + content +"</textarea>";
      }
      
          //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=Ide&Methode=LoadCodeTemplate";
       JAjax.data += "&Projet=" + projet;
       JAjax.data += "&Module=" + module;
       JAjax.data += "&File=" + file;
       JAjax.data += "&ShowStyle=true";
       
      content = JAjax.GetRequest("Ajax.php");
      
      IdeBrowser.innerHTML = content;
      
       //Ajoute le fichier css
    //Rajouter le nouveau fichier css
   // IdeElement.RemoveJs("../Apps/" + Ide.Projet + "/" + Ide.Projet + ".css");
   // IdeElement.IncludeJs("../Apps/" + Ide.Projet + "/" + Ide.Projet + ".css");
};

/**
 * Sauvegare le template courant ainsi que le fichier css
 * @param {type} projet
 * @param {type} module
 * @param {type} file
 * @returns {undefined}Enregistre le template
 */
IdeElement.SaveTemplate = function(projet, module, file)
{
    //Todo supprimer le fichier css
    IdeElement.RemoveCss("../Data/Apps/Ide/" + projet + "/" + projet + ".css");
    
    
    var tbCodeTemplate = document.getElementById("tbCodeTemplate");
    var tbCssFiles = document.getElementById("tbCssFiles");
  
    //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=Ide&Methode=SaveTemplate";
       JAjax.data += "&Projet=" + projet;
       JAjax.data += "&Module=" + module;
       JAjax.data += "&File=" + file;
       JAjax.data += "&Content=" + tbCodeTemplate.value;
       JAjax.data += "&CssContent=" + tbCssFiles.value;
      
      //TODO supprimer les caractere speciaux
      content = JAjax.GetRequest("Ajax.php");
      
    //Rajouter le nouveau fichier css
      IdeElement.IncludeCss("../Data/Apps/Ide/" + projet + "/" + projet + ".css?rand"+Math.random(00, 10000));
};

/*
* Inclu le fichier javascript
*/
IdeElement.IncludeJs = function(file)
{
    var script = document.createElement('script');
    script.setAttribute('type','text/javascript');
    script.setAttribute('src', file);
    script.setAttribute('id', 'AppScript');

    document.body.appendChild(script);
};

/**
 * Enlelve le fichier css pour rafrichissement
 * 
 * @param file
 * @returns
 */
IdeElement.RemoveJs = function(file)
{
  var scripts = document.getElementsByTagName("script");
  
  for(i=0; i< scripts.length; i++)
  {
      if(scripts[i].src.indexOf(file.replace("../Apps", "")) > -1 )
      {
          document.body.removeChild(scripts[i]);
      }
  }
};

/*
 * Ajoute le fichier CSS
 * @param 
 * @returns 
 */
IdeElement.IncludeCss = function(file)
{
    var script = document.createElement('link');
    script.setAttribute('type','text/css');
    script.setAttribute('href', file);

    script.setAttribute('rel', 'stylesheet');
    document.body.appendChild(script);
  //TODO Verifier que le script existe
};

/**
 * Supprime le fichiers css
 * @param  file
 * @returns 
 */
IdeElement.RemoveCss = function(file)
{
    var links = document.getElementsByTagName('link');
    
    for(i= 0; i < links.length; i++)
    {
        if(links[i].href == file)
        {
            document.body.removeChild(links[i]);
        }
    }
};

/**
 * PopIn d'ajout de helper
 * 
 * @returns 
 */
IdeElement.ShowAddHelper = function()
{
    var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.NewHelper';
    param['Projet'] = Ide.Projet;
    
    Dashboard.OpenPopUp('Ide','ShowAddHelper', '','','', 'IdeElement.LoadRefreshHelper()', serialization.Encode(param));
};

/**
 * Charge le code d'un module
 * @returns 
 */
IdeElement.LoadCodeHelper = function(helper)
{
   IdeElement.LoadFile("", "", helper);
};

/**
 * Rafraichit la liste des helpers
 * @returns 
 */
IdeElement.LoadRefreshHelper = function()
{
    var data = "Class=Ide&Methode=LoadHelper&App=Ide&Projet=" +  Ide.Projet;
    Dashboard.LoadControl("lstHelper", data, "" , "div", "Ide");    
};

/**
 * Affiche le détail de l'image
 * @param file
 * @return
 */
IdeElement.LoadImage = function(file)
{
    var param = Array();
    param['App'] = 'Ide';
    param['Title'] = 'Ide.DetailImage';
    param['Projet'] = Ide.Projet;
    param['File'] = file;
    
    Dashboard.OpenPopUp('Ide','ShowImage', '','', '', '', '', serialization.Encode(param));
};

/**
 * Rafraichit le repertoire des images
 * @returns {undefined}
 */
IdeElement.RefreshImageObjet = function()
{
    var data = "Class=Ide&Methode=LoadImage&App=Ide&Projet=" +  Ide.Projet;
    Dashboard.LoadControl("lstImage", data, "" , "div", "Ide");
};

/**
 * 
 * @returns {undefined}Passe les scripts de creation des tables 
 */
IdeElement.CreateTable = function()
{
    //Creation de la requete
     var JAjax = new ajax();
         JAjax.data = "App=Ide&Methode=CreateTable";
         JAjax.data += "&Projet="+ Ide.Projet;
    
      //TODO supprimer les caractere speciaux
      content = JAjax.GetRequest("Ajax.php");
      
      alert(content);
};

var IdeInsert = function() {};

/**
 * Déclenché lorsque l'on selectionne une fonction
 * @param 
 * @returns 
 */
IdeInsert.fonctionJsSelected = function(e)
{
    if(e.value != "")
    {
        IdeInsert.Fonction = e.value;

        var dvInsertParameter = document.getElementById("dvInsertParameter");

        var JAjax = new ajax();
            JAjax.data = 'App=Ide&Methode=GetParameterJsFonction&Fonction=' + e.value;

        dvInsertParameter.innerHTML= JAjax.GetRequest('Ajax.php');
    }
};

/**
 * Retourne le template du code
 * @returns 
 */
IdeInsert.GetCodeTemplate = function(type)
{
    var dvInsertParameter = document.getElementById("dvInsertParameter");
    
    var controls = dvInsertParameter.getElementsByTagName("input");
    var parameters = Array();
    
    for(i = 0; i < controls.length ; i++)
    {
        parameters.push(controls[i].id + ":" + controls[i].value);
    }
    
    var JAjax = new ajax();
    	JAjax.data = 'App=Ide&Methode=GetCodeTemplate&Fonction=' + IdeInsert.Fonction;
        JAjax.data += '&Parameter=' + parameters.join("_-");
        JAjax.data += '&Type=' + type;
        
    dvInsertParameter.innerHTML= JAjax.GetRequest('Ajax.php');
};

/**
 * Déclenché lorsque l'on selectionne une fonction
 * @param 
 * @returns 
 */
IdeInsert.fonctionPhpSelected = function(e)
{
    if(e.value != "")
    {
        IdeInsert.Fonction = e.value;

        var dvInsertParameter = document.getElementById("dvInsertParameter");

        var JAjax = new ajax();
            JAjax.data = 'App=Ide&Methode=GetParameterPhpFonction&Fonction=' + e.value;

        dvInsertParameter.innerHTML= JAjax.GetRequest('Ajax.php');
    }
};


var IdeTool = function(){};

/**
 * Lance l'application courante
 */
IdeTool.Play = function()
{
    Dashboard.StartApp("", Ide.Projet);
};

/**
 * Lance l'application courante
 */
IdeTool.Save = function()
{
    //Enregistrement des autre fichiers
    for(k=1 ; k < 10; k++)
    {
            var content =  Dashboard.GetElement("tb_" + k ,"textarea","Ide");
            if(typeof(content) != 'undefined')
            {
                    //Recuperation du nom du fichier
                    var onglet = Dashboard.GetElement("index_" + k ,"th","Ide");

                    content = IdeTool.Replace(content.value,'"','!-!');
                    content = IdeTool.Replace(content,"'",'-!!-');
                    content = IdeTool.Replace(content,"&",'-!-');
                    content = IdeTool.Replace(content,"+",'!--!');

                    var JAjax = new ajax();
                    JAjax.data = "App=Ide&Methode=SaveFileProject&name=" + onglet.title;
                    JAjax.data += "&Projet=" + Ide.Projet;
                    JAjax.data += "&code=" + content;

                    JAjax.GetRequest("Ajax.php");
            }
            else
            {
                    break;
            }
    }
};

/*
* Remplace les & car sinon provoque une erreur
* dans les variables post�s
*/
IdeTool.Replace = function(expr,a,b)
{
  var i=0;
  while (i!=-1) {
     i=expr.indexOf(a,i);
     if (i>=0) {
        expr=expr.substring(0,i)+b+expr.substring(i+a.length);
        i+=b.length;
     }
  }
  return expr;
};

/**
 * Rfrachit le navigateur
 * @returns
 */
IdeTool.Refresh = function()
{
    IdeElement.SaveTemplate(Ide.Projet, Ide.Module, Ide.File);
    IdeElement.LoadCodeTemplate(Ide.Projet, Ide.Module, Ide.File, false);
};

/**
 * Deploy l'application sur Webemyos
 */
IdeTool.Deploy = function()
{
    if(confirm("Deploy"))
    {
        IdeTool.ShowMessage("Deploiement en cours");

       var JAjax = new ajax();
           JAjax.data = "App=Ide&Methode=Deploy";
           JAjax.data += "&Projet=" + Ide.Projet;

        alert(JAjax.GetRequest("Ajax.php"));
        IdeTool.ShowMessage(""); 
    }
};

/*
 * Affiche un message 
 */
IdeTool.ShowMessage = function(message)
{
    var spInfo = document.getElementById("spToolInfo");
    spInfo.innerHTML = message;
};

/**
 * Outil de gestion de la landing page OR Page Application de webemyos
 * @returns {undefined}
 */
IdeTool.LoadLandingPage =function()
{
  var data = "Class=Ide&Methode=LoadLandingPage&App=Ide";
      data += "&Projet=" + Ide.Projet;
      
      Dashboard.LoadControl("appCenter", data, "" , "div", "Ide");
};
var IdeTool = function(){};

/**
 * Lance l'application courante
 */
IdeTool.Play = function()
{
    Dashboard.StartApp("", Ide.Projet);
};

/**
 * Lance l'application courante
 */
IdeTool.Save = function()
{
    //Enregistrement des autre fichiers
    for(k=1 ; k < 10; k++)
    {
            var content =  Dashboard.GetElement("tb_" + k ,"textarea","Ide");
            if(typeof(content) != 'undefined')
            {
                    //Recuperation du nom du fichier
                    var onglet = Dashboard.GetElement("index_" + k ,"th","Ide");

                    content = IdeTool.Replace(content.value,'"','!-!');
                    content = IdeTool.Replace(content,"'",'-!!-');
                    content = IdeTool.Replace(content,"&",'-!-');
                    content = IdeTool.Replace(content,"+",'!--!');

                    var JAjax = new ajax();
                    JAjax.data = "App=Ide&Methode=SaveFileProject&name=" + onglet.title;
                    JAjax.data += "&Projet=" + Ide.Projet;
                    JAjax.data += "&code=" + content;

                    JAjax.GetRequest("Ajax.php");
            }
            else
            {
                    break;
            }
    }
};

/*
* Remplace les & car sinon provoque une erreur
* dans les variables post�s
*/
IdeTool.Replace = function(expr,a,b)
{
  var i=0;
  while (i!=-1) {
     i=expr.indexOf(a,i);
     if (i>=0) {
        expr=expr.substring(0,i)+b+expr.substring(i+a.length);
        i+=b.length;
     }
  }
  return expr;
};

/**
 * Rfrachit le navigateur
 * @returns
 */
IdeTool.Refresh = function()
{
    IdeElement.SaveTemplate(Ide.Projet, Ide.Module, Ide.File);
    IdeElement.LoadCodeTemplate(Ide.Projet, Ide.Module, Ide.File, false);
};

/**
 * Deploy l'application sur Webemyos
 */
IdeTool.Deploy = function()
{
    if(confirm("Deploy"))
    {
        IdeTool.ShowMessage("Deploiement en cours");

       var JAjax = new ajax();
           JAjax.data = "App=Ide&Methode=Deploy";
           JAjax.data += "&Projet=" + Ide.Projet;

        alert(JAjax.GetRequest("Ajax.php"));
        IdeTool.ShowMessage(""); 
    }
};

/*
 * Affiche un message 
 */
IdeTool.ShowMessage = function(message)
{
    var spInfo = document.getElementById("spToolInfo");
    spInfo.innerHTML = message;
};

/**
 * Outil de gestion de la landing page OR Page Application de webemyos
 * @returns {undefined}
 */
IdeTool.LoadLandingPage =function()
{
  var data = "Class=Ide&Methode=LoadLandingPage&App=Ide";
      data += "&Projet=" + Ide.Projet;
      
      Dashboard.LoadControl("appCenter", data, "" , "div", "Ide");
};

