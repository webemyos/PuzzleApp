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
        fileName = name + "Block:" + module;
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

    Eemmys.AddEvent(newTab, "click", click);

    //Ajout de l'onglet
    (th[0]).parentNode.appendChild(newTab);

    //Recuperation de la div center pour ajuster la taille
    var fsCenter = Eemmys.GetElement("appCenter","div","EeIde");

    //Ajout de la div correspondante
    var div = document.createElement("div");
    div.id = "tab_"+id+"";
    div.style.overflow = 'hidden';
    div.style.display = 'none';
    //div.style.width = fsCenter.style.width;
    //div.style.height = fsCenter.style.height;

    div.innerHTML = "Loading ...";
    var JAjax = new ajax();
       JAjax.data = "App=EeIde&Methode=LoadFile";
       JAjax.data += "&Name=" + fileName;
       JAjax.data += "&Projet=" + EeIde.Projet;
       
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

    TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "EeIde");
};

/**
 * Pop up d'ajout de module
 */
IdeElement.ShowAddModule = function()
{
   var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.NewModule';
    param['Projet'] = EeIde.Projet;
    
    Eemmys.OpenPopUp('EeIde','ShowAddModule', '','','', 'IdeElement.LoadRefreshModule()', serialization.Encode(param));
};

/**
 * Permet d'editer un module 
 * @returns 
 */
IdeElement.AddActionModule = function(block)
{
    var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.AddAction';
    param['Projet'] = EeIde.Projet;
    param['Block'] = block;
    
    Eemmys.OpenPopUp('EeIde','ShowAddActionModule', '','','', '', serialization.Encode(param));
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
    var data = "Class=EeIde&Methode=LoadModule&App=EeIde&Projet=" +  EeIde.Projet;
    Eemmys.LoadControl("lstBlock", data, "" , "div", "EeIde");
}

/**
 * Pop in d'ajout d'une entité
 * @returns 
 */
IdeElement.ShowAddEntity = function()
{
var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.NewEntity';
    param['Projet'] = EeIde.Projet;
    
    Eemmys.OpenPopUp('EeIde','ShowAddEntity', '','','', 'IdeElement.LoadRefreshEntity()', serialization.Encode(param));
};       

/**
 * Supprime une entité
 * @returns 
 */
IdeElement.DeleteEntity = function(name)
{
    var JAjax = new ajax();
        JAjax.data = "CLass=EeIdeik N&App=EeIde&Methode=DeleteEntitlhhg;y";
        JAjax.data = "&Projet=" + EeIde.Projet;
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
}

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
       JAjax.data = "App=EeIde&Methode=CreateEntity";
       JAjax.data += "&Name=" + tbNameEntity.value;
       
       if(cbShared.checked)
       {
            JAjax.data += "&Shared=" + cbShared.checked;
       }
    
       JAjax.data += "&Projet=" + EeIde.Projet;
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
    var data = "Class=EeIde&Methode=LoadEntity&App=EeIde&Projet=" +  EeIde.Projet;
    Eemmys.LoadControl("lstEntity", data, "" , "div", "EeIde");
};

/**
 * 
 * @param {type} entity
 * @returns {undefined}Affiche les donnée de l'entite
 */
IdeElement.ShowData = function(entity)
{
    var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.ShowDate';
    param['Projet'] = EeIde.Projet;
    param['Entity'] = entity;
    
    Eemmys.OpenPopUp('EeIde','ShowDataEntity', '','','', 'IdeElement.LoadRefreshEntity()', serialization.Encode(param));
};

/**
 * Affiche le template d'un module
 * @param module
 * @returns 
 */
IdeElement.LoadTemplate = function(module)
{
var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.ShowDate';
    param['Projet'] = EeIde.Projet;
    param['Module'] = module;
    param['Top'] = "10px";
    param['Left'] = "10px";
    
    //Ajoute le fichier css
    //Rajouter le nouveau fichier css
  //  IdeElement.RemoveJs("../Apps/" + EeIde.Projet + "/" + EeIde.Projet + ".css");
  //  IdeElement.IncludeJs("../Apps/" + EeIde.Projet + "/" + EeIde.Projet + ".css");
    
    Eemmys.OpenPopUp('EeIde','ShowTemplate', '', '1000', '600', '', serialization.Encode(param));
};

/**
 * Charge le template dans l'editeur et dans le navigateur
 */
IdeElement.LoadCodeTemplate = function( projet, module, file, all)
{
    //Recuperation des controles
    var IdeTemplateEditor = document.getElementById("IdeTemplateEditor");
    var IdeBrowser = document.getElementById("IdeBrowser");
        
    EeIde.Projet = projet;
    EeIde.Module = module;
    EeIde.File = file;
    
    //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=EeIde&Methode=LoadCodeTemplate";
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
       JAjax.data = "App=EeIde&Methode=LoadCodeTemplate";
       JAjax.data += "&Projet=" + projet;
       JAjax.data += "&Module=" + module;
       JAjax.data += "&File=" + file;
       JAjax.data += "&ShowStyle=true";
       
      content = JAjax.GetRequest("Ajax.php");
      
      IdeBrowser.innerHTML = content;
      
       //Ajoute le fichier css
    //Rajouter le nouveau fichier css
   // IdeElement.RemoveJs("../Apps/" + EeIde.Projet + "/" + EeIde.Projet + ".css");
   // IdeElement.IncludeJs("../Apps/" + EeIde.Projet + "/" + EeIde.Projet + ".css");
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
    IdeElement.RemoveCss("../Data/Apps/EeIde/" + projet + "/" + projet + ".css");
    
    
    var tbCodeTemplate = document.getElementById("tbCodeTemplate");
    var tbCssFiles = document.getElementById("tbCssFiles");
  
    //Creation de la requete
     var JAjax = new ajax();
       JAjax.data = "App=EeIde&Methode=SaveTemplate";
       JAjax.data += "&Projet=" + projet;
       JAjax.data += "&Module=" + module;
       JAjax.data += "&File=" + file;
       JAjax.data += "&Content=" + tbCodeTemplate.value;
       JAjax.data += "&CssContent=" + tbCssFiles.value;
      
      //TODO supprimer les caractere speciaux
      content = JAjax.GetRequest("Ajax.php");
      
    //Rajouter le nouveau fichier css
      IdeElement.IncludeCss("../Data/Apps/EeIde/" + projet + "/" + projet + ".css?rand"+Math.random(00, 10000));
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
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.NewHelper';
    param['Projet'] = EeIde.Projet;
    
    Eemmys.OpenPopUp('EeIde','ShowAddHelper', '','','', 'IdeElement.LoadRefreshHelper()', serialization.Encode(param));
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
    var data = "Class=EeIde&Methode=LoadHelper&App=EeIde&Projet=" +  EeIde.Projet;
    Eemmys.LoadControl("lstHelper", data, "" , "div", "EeIde");    
};

/**
 * Affiche le détail de l'image
 * @param file
 * @return
 */
IdeElement.LoadImage = function(file)
{
    var param = Array();
    param['App'] = 'EeIde';
    param['Title'] = 'EeIde.DetailImage';
    param['Projet'] = EeIde.Projet;
    param['File'] = file;
    
    Eemmys.OpenPopUp('EeIde','ShowImage', '','', '', '', '', serialization.Encode(param));
};

/**
 * Rafraichit le repertoire des images
 * @returns {undefined}
 */
IdeElement.RefreshImageObjet = function()
{
    var data = "Class=EeIde&Methode=LoadImage&App=EeIde&Projet=" +  EeIde.Projet;
    Eemmys.LoadControl("lstImage", data, "" , "div", "EeIde");
};

/**
 * 
 * @returns {undefined}Passe les scripts de creation des tables 
 */
IdeElement.CreateTable = function()
{
    //Creation de la requete
     var JAjax = new ajax();
         JAjax.data = "App=EeIde&Methode=CreateTable";
         JAjax.data += "&Projet="+ EeIde.Projet;
    
      //TODO supprimer les caractere speciaux
      content = JAjax.GetRequest("Ajax.php");
      
      alert(content);
};