function Notification()
{
    this.Notify = function(message)
    {
        var popupNotify = document.getElementById("popupNotify");

    if(dvMessage == undefined)
    {

    var dvMessage = document.createElement("div");
        dvMessage.id = "popupNotify";
        dvMessage.style.zIndex = 9999;
        dvMessage.style.position = "fixed";
        dvMessage.style.top="0px";
        dvMessage.style.right="0px";
        dvMessage.style.padding = "10px";
        dvMessage.style.height = "100px";
        dvMessage.style.color = "black";
        dvMessage.style.background = "rgba(236, 250, 251, 1)";
       
        document.body.appendChild(dvMessage); 
    }
    else
    {
        dvMessage.style.display = "block";
    }

    dvMessage.innerHTML = "<p style='text-align:center;padding-top:20px;' class='extrabold upper'>" + message + "</p>";
   
    setTimeout(function(){   var dvMessage = document.getElementById("popupNotify"); dvMessage.style.display = "none";  },  2000);
    }
}