function PopUp(propriete, argument, action, sourceControl, )
{
    //Deserialisation
	property=new Array();
	property = serialization.Decode(propriete);

	arg=new Array();
	arg = serialization.Decode(argument);

        actions = new Array();
	actions = serialization.Decode(action);

	sourceControls = new Array();
	sourceControls = serialization.Decode(sourceControl);

	//Propriete
	this.core="";
	this.page = "Ajax.php";
	this.idEntity=arg["idEntity"];

	this.data +="&Arg="+argument;

	for(ar in arg)
	{
		 this.data += "&"+ar+"="+arg[ar];
	}

	//ajout des control source
	for(control in sourceControls)
	{
		if(control != "")
		{
			var ctr = document.getElementById(control);

			if(ctr != null)
			{
				this.data += "&"+ control + "=" + ctr.value;
			}
		}
	}

	this.Open=function()
	{
        if(property["ShowBack"] == true || property["ShowBack"] == "1")
		{
			// Ajout d'un div Grise
			this.backGround = document.createElement('div');
			this.backGround.style.height = document.body.parentNode.scrollHeight + "px";
			this.backGround.id = "back";

			document.body.appendChild(this.backGround);
		}

		this.core = document.createElement('div');

	var i=0;
	while(document.getElementById(property['Name']+i) != null)
	{
		i++;
	}

	this.core.id = property['Name']+i;
	this.core.className = "popup";
	//Bug IE
	//this.core.style.width= property["Width"]+"px";
	//this.core.style.height=property["Height"]+"px";

    //centrage de la fenetre
    if(property["Left"] != "")
    {
     this.core.style.left=property["Left"];
    }
    else
    {
    //this.core.style.left = "20%";
	 if(property["Width"].indexOf("px") != '-1')
	  width = property["Width"].slice(0, -2);
	   else width = property["Width"];
	 this.core.style.marginLeft = "-" + Math.floor(width / 2) + "px";
    }

	if(property["Top"] != "")
	{
	 this.core.style.top = property["Top"];
	}
	else
	{
		//this.core.style.top = "35%";
		if(property["Height"].indexOf("px") != '-1')
		{
		 height = property["Height"].slice(0, -2);
		}
		else
		{
		 height = property["Height"];
		}
		height = (-Math.floor(height / 2)) + document.body.scrollTop + document.documentElement.scrollTop + 10;
		this.core.style.marginTop = Math.floor(height) + "px";
	}
	this.Classe = property["Class"];
	this.RefreshPage = property["RefreshPage"];

    //Remplacement des caracteres
    if(actions["OnClose"] != null)
    {
     var i=0;var b='"';
      while (i!=-1)
       {
         i=actions["OnClose"].indexOf("*",i);
         if (i>=0) {
            actions["OnClose"]=actions["OnClose"].substring(0,i)+b+actions["OnClose"].substring(i+"*".length);
            i+=b.length;
         }
      }
    this.onClose = actions["OnClose"];
   }
   else
   {
    this.onClose ="";
   }
	tool=document.createElement('div');
                
         this.core.appendChild(tool);

    //tool.innerHTML="<table  style='width:100%;' class='titre'><tr><td  style='text-align:left;' >"+property["Title"]+"</td><td style='text-align:right;'><img src='Images/maximize.png' alt='' title='Fermer' onclick='Maximize(\""+this.core.id+"\")' ><img src='Images/delete.png' alt='' title='Fermer' onclick='Close(\""+this.core.id+"\",\""+this.Classe+"\",\""+this.RefreshPage+"\");"+this.onClose+"' ></td><td style='width:15px'></td></tr></table>";
 	tool.innerHTML="<span class='title' style='display:inline-block;width:95%'>"+ Dashboard.GetCode(property["Title"])+"</span><span class='fa fa-remove' style='display:inline-block;text-align:right' id='btnClosePopUp' title='Fermer' onclick='Close(\""+this.core.id+"\",\""+this.Classe+"\",\""+this.RefreshPage+"\");"+this.onClose+"'></span>";

	 this.page +="?idEntity="+this.idEntity;

	 this.frame=document.createElement('iframe');
	 this.frame.style.width=property["Width"];
	 this.frame.style.height=property["Height"];

	if(property["ControllerType"] != undefined && property["ControllerType"] == "Front")
	{
		this.core.innerHTML += "<popupcontent></popupcontent>";
		Dashboard.LoadModule(property["App"], property["Module"], "popupcontent");
	}

	else if(typeof(arg["Url"]) == 'undefined' || arg["Url"] == "")
   	 {
   	   	 this.core.innerHTML +="<span id='Fermer' onclick='document.body.removeChild(this.parentNode);' ></span>"+this.Send();
	 }
	 else
	 {
	 	 if(this.idEntity != undefined)
		 {
		 	if(arg["Url"].indexOf('?')>0)
	 		{
		 		this.frame.src = arg["Url"]+"&idEntity="+this.idEntity+this.data;
	 		}
		 	else
		 	{
	 			this.frame.src = arg["Url"]+"?idEntity="+this.idEntity+this.data;
			}
		 }
		 else
		 {
		 	if(arg["Url"].indexOf('?')>0)
	 		{
		 		this.frame.src = arg["Url"]+"&"+this.data;
			}
		 	else
		 	{
	 			this.frame.src = arg["Url"]+"?"+this.data;
			}
		 }

		 	this.core.appendChild(this.frame);
	 }

    document.body.appendChild(this.core);

	};

	this.Close=function()
	{
  		document.body.removeChild(block);
  	};

	this.Send=function()
	{
	  var JAjax = new ajax();
	  JAjax.data = this.data;
	  return JAjax.GetRequest(this.page);
	};
};

function Maximize(popup)
{

   po=document.getElementById(popup);
   fr=po.getElementsByTagName("iframe");

	if(po.style.width == "1000px")
	{
		po.style.width = "300px";
		po.style.height ="40px";
		fr[0].style.width = "300px";
		fr[0].style.height ="20px";
	}
	else
	{
		po.style.width = "1000px";
		po.style.height ="800px";
		fr[0].style.width = "1000px";
		fr[0].style.height ="800px";
	}
};

function Close(popup,classe,url)
{
 	if(typeof(Dashboard) != 'undefined')
 	{
 		Dashboard.CloseSearch();
 	}

 	//Fermeture des calendrier
 	//closeCalendar();

 	po=document.getElementById(popup);
    document.body.removeChild(po);

    backGround = document.getElementById("back");
    document.body.removeChild(backGround);
};

function ClosePopUp(popup)
{
	Dashboard.CloseSearch();

	po=document.getElementById("popup0");
    document.body.removeChild(po);

    backGround = document.getElementById("back");

    if(backGround)
    	document.body.removeChild(backGround);
};
