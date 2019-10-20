var Dialog = function(){};

/**
 * Add Event on The DialogButton
 */
Dialog.Init = function()
{
    var dialogs = document.getElementsByClassName("dialogButton");

    for(var i = 0; i < dialogs.length; i++)
    {
        Dashboard.AddEvent(dialogs[i], "click", Dialog.open);
    }
};

/**
 * Open Dialog
 * And load Content From the App/Module
 * @param {*} e 
 */
Dialog.open = function(e, data)
{

    if(e != '')
    {
        e.preventDefault;
        Dialog.data = e.srcElement.parentNode.dataset;
    }
    else
    {
        Dialog.data = data;
    }
   
    if(Dialog.data.type != undefined)
    {
        var dialog = document.getElementById("rightDialog");

        if(dialog == undefined)
        {
            var dialog = document.createElement('div'); 
            dialog.id = "rightDialog";
            var created = false;
        }
        else
        {
            var created = true;
        }

        dialog.className = Dialog.data.type ;
        dialog.style.width="0px";
        dialog.style.padding = "10px";
    }
    else
    {
        var dialog = document.createElement('div');
        var created = false;

        dialog.zIndex = 9999;
        dialog.style.opacity = 0;

        dialog.id='dialog';

        // Ajout d'un div Grise
        var backGround = document.createElement('div');
            backGround.style.height = document.body.parentNode.scrollHeight + "px";
            backGround.id = "back";
            backGround.zIndex = "9";

        document.body.appendChild(backGround);
    }

        var html = "<div id='DialogTitle'>"+Dialog.data.title;
            html += "<span style='float:right' class='DialogClose'  id='DialogClose'><i class='fa fa-remove'>&nbsp</i></span> ";
            html += "</div>";
            
           if(Dialog.data.type != undefined)
           {
                html += "<div id='DialogRighContent'><img src='images/loading/load.gif' alt='Loading'/></div>";
                dialog.innerHTML = html;
           } else {

                html += "<div id='DialogContent'><img src='images/loading/load.gif' alt='Loading'/></div>";
                dialog.innerHTML = html;
           }

        if(created == false){
                document.body.appendChild(dialog);
        }
      
       // Animation.Show("dialog", 50);

    //On determine si on est sur un réseau 
    var urls = document.location.href.split("/");
    
    if(Dialog.data.type != undefined)
    {
        var DialogContent = document.getElementById("DialogRighContent");
    }
    else
    {
        var DialogContent = document.getElementById("DialogContent");
    }
    DialogContent.innerHTML = data;


    if(Dialog.data.html)
    {
        DialogContent.innerHTML = Dialog.data.html;
       
        Dashboard.AddEventByClass("DialogClose", "click", Dialog.close);
        setTimeout(() => {
            dialog.style.width = "40%"; 
            dialog.style.opacity = 100;
        }, 100);
    }
    else{
    
    //Pour atteindre Ajax.php de la racine
    var ajaxFile = urls[0] + "/"+  urls[1] +  "/" + urls[2] + "/Ajax.php" ;

    //Chargement
    Request.Post(ajaxFile, "App="+Dialog.data.app+"&Class="+Dialog.data.class + "&Methode=" + Dialog.data.method + "&Params=" + Dialog.data.params).then(data=>{

        Dashboard.AddEventByClass("DialogClose", "click", Dialog.close);
    var DialogContent = document.getElementById("DialogContent");
        DialogContent.innerHTML = data;

      
        var controller = Dialog.data.class + "Controller";
        var methode= controller + "." + Dialog.data.method + "()";
        dialog.style.opacity = 100;
        //Appel de la méthode Js 
        // Ne pas oublier d'inclure le scrip Js du module
        eval(methode);
    });
}
};

/**
 * Close the dialog
 */
Dialog.close = function()
{
    console.log("Close");

    var rightDialog = document.getElementById("rightDialog");

    if(rightDialog != undefined)
    {
        rightDialog.style.width = "0px";
        rightDialog.style.padding="0px";
    }
   
    Animation.FadeOut("dialog", 50, function(){
        var backGround = document.getElementById('back');
        var dialog = document.getElementById("dialog");
    
        backGround.parentNode.removeChild(backGround);
        dialog.parentNode.removeChild(dialog);
        }
    );
};

