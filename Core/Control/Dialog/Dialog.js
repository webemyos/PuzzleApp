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
Dialog.open = function(e)
{
    e.preventDefault;

    Dialog.data = e.srcElement.parentNode.dataset;


    // Ajout d'un div Grise
    var backGround = document.createElement('div');
        backGround.style.height = document.body.parentNode.scrollHeight + "px";
        backGround.id = "back";
        backGround.zIndex = "9";

    document.body.appendChild(backGround);

    var dialog = document.createElement('div');
        dialog.id='dialog';
        dialog.zIndex = 9999;
        dialog.style.opacity = 0;

        var html = "<div id='DialogTitle'>"+Dialog.data.title;
            html += "<span style='float:right' id='DialogClose'><i class='fa fa-remove'>&nbsp</i></span> ";
            html += "</div>";
            
            html += "<div id='DialogContent'><img src='images/loading/load.gif' alt='Loading'/></div>";
            dialog.innerHTML = html;

        document.body.appendChild(dialog);

      Animation.FadeIn("dialog", 50);

    //Chargement
    Request.Post("Ajax.php", "App="+Dialog.data.app+"&Class="+Dialog.data.class + "&Methode=" + Dialog.data.method).then(data=>{

        Dashboard.AddEventById("DialogClose", "click", Dialog.close);

        var DialogContent = document.getElementById("DialogContent");
        DialogContent.innerHTML = data;

        var controller = Dialog.data.class.split(".");
        var methode= controller[controller.length -1 ] + "." + Dialog.data.method + "()";

        //Appel de la méthode Js 
        // Ne pas oublier d'inclure le scrip Js du module
        eval(methode);
    });

};

/**
 * Close the dialog
 */
Dialog.close = function()
{
    Animation.FadeOut("dialog", 50, function(){
        var backGround = document.getElementById('back');
        var dialog = document.getElementById("dialog");
    
        backGround.parentNode.removeChild(backGround);
        dialog.parentNode.removeChild(dialog);
        }
    );
};

