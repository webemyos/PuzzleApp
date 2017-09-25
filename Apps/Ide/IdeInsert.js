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
            JAjax.data = 'App=EeIde&Methode=GetParameterJsFonction&Fonction=' + e.value;

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
    	JAjax.data = 'App=EeIde&Methode=GetCodeTemplate&Fonction=' + IdeInsert.Fonction;
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
            JAjax.data = 'App=EeIde&Methode=GetParameterPhpFonction&Fonction=' + e.value;

        dvInsertParameter.innerHTML= JAjax.GetRequest('Ajax.php');
    }
};
