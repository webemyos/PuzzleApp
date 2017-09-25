var IdeTool = function(){};

/**
 * Lance l'application courante
 */
IdeTool.Play = function()
{
    Eemmys.StartApp("", EeIde.Projet);
};

/**
 * Lance l'application courante
 */
IdeTool.Save = function()
{
    //Enregistrement des autre fichiers
    for(k=1 ; k < 10; k++)
    {
            var content =  Eemmys.GetElement("tb_" + k ,"textarea","EeIde");
            if(typeof(content) != 'undefined')
            {
                    //Recuperation du nom du fichier
                    var onglet = Eemmys.GetElement("index_" + k ,"th","EeIde");

                    content = IdeTool.Replace(content.value,'"','!-!');
                    content = IdeTool.Replace(content,"'",'-!!-');
                    content = IdeTool.Replace(content,"&",'-!-');
                    content = IdeTool.Replace(content,"+",'!--!');

                    var JAjax = new ajax();
                    JAjax.data = "App=EeIde&Methode=SaveFileProject&name=" + onglet.title;
                    JAjax.data += "&Projet=" + EeIde.Projet;
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
    IdeElement.SaveTemplate(EeIde.Projet, EeIde.Module, EeIde.File);
    IdeElement.LoadCodeTemplate(EeIde.Projet, EeIde.Module, EeIde.File, false);
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
           JAjax.data = "App=EeIde&Methode=Deploy";
           JAjax.data += "&Projet=" + EeIde.Projet;

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
  var data = "Class=EeIde&Methode=LoadLandingPage&App=EeIde";
      data += "&Projet=" + EeIde.Projet;
      
      Eemmys.LoadControl("appCenter", data, "" , "div", "EeIde");
};
