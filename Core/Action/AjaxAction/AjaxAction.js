function Jax(propriete, argument, messageConfirm)
{
	if(messageConfirm != "")
 	{
		if(confirm(messageConfirm))
		{
			var Action = new AjaxAction(propriete, argument);
			Action.DoAction();
		}
	}
	else
	{
		var Action = new AjaxAction(propriete, argument);
			Action.DoAction();
	}
};

function AjaxAction(propriete, argument)
{
		//Deserialisation
		property=new Array();
		property = serialization.Decode(propriete);

		arg=new Array();
		arg = serialization.Decode(argument);

		var asyncrhone = arg["Asynchrone"];

		//Propriete
		this.page = "Ajax.php";

		this.data +="&Arg="+argument;

		for(ar in arg)
		{
  			this.data += "&"+ar+"="+arg[ar];
		}

		this.DoAction = function (propriete, argument)
		{
			var sourceControl = document.getElementById(property["SourceControl"]);
			var ChangedControl = document.getElementById(property["ChangedControl"]);

			if(sourceControl != null)
			{
				this.data +="&sourceControl="+sourceControl.value;
			}

                        //Recuperation des controles
			if(typeof(property["SourceControls"]) != 'undefined')
			{
				var sourceControls = property["SourceControls"].split("-");

				for(i=0;i<sourceControls.length;i++)
				{
					control = document.getElementById(sourceControls[i]);

					if(control != null)
					{
						if(control.type == "checkbox" || control.type == "checkBox")
						{
                                                 	if(control.checked)
								this.data += "&"+sourceControls[i]+"="+ '1';
							else
								this.data += "&"+sourceControls[i]+"="+ false;
						}
                                                else
						{
                                                    //Remplacement des caractere spéciaux pour le ckeditor
                                                       var myRegEx=new RegExp("&", "gm");
                                                           control.value= control.value.replace(myRegEx , "!et!");
						
                                                        this.data += "&"+sourceControls[i]+"="+control.value;
                        			}
					}
				}
			}
			//Si c'est un div on supprime et on recre
			if(property["DisabledOnLoad"] == true)
			{
				//Enregistrement de la zone de saisie
				this.ChangedControl = ChangedControl.id;

				if(property["ChangeContent"] == 'none')
				{
					property["Text"] = ChangedControl.innerHTML ;
				}

				ChangedControl.className = "loading";
				ChangedControl.innerHTML = 	"<center><img src='../Images/loading/load.gif' alt='Wait' title='wait' /></center>";

				//Emission de la requete
				var result = serialization.Decode32(this.Send());
				ChangedControl.innerHTML = result[0];

				if(property["ChangeContent"] != 'none')
				{
					property["Text"] = result[1] ;
				}
				//Reactivation de la zone de saisie
				setTimeout(this.Reactive,1000);
			}
			else if(ChangedControl.nodeName == "DIV")
			{
				var parent = ChangedControl.parentNode;
        		var NdivWait = document.createElement("div" );
              	NdivWait.id = ChangedControl.id;
				NdivWait.innerHTML = "<center><img src='Images/loading/load.gif' alt='Wait' title='wait' /></center>";

              	parent.removeChild(ChangedControl);
	            parent.appendChild(NdivWait);

	            //Creation de la nouvelle div
	            var Ndiv = document.createElement("div" );
	            Ndiv.id = NdivWait.id;
	            if(asyncrhone == 1)
	            {
	            	this.Send(Ndiv.innerHTML);
	            }
	            else
	            {
	            	Ndiv.innerHTML = this.Send();
	            }

	            parent.removeChild(NdivWait);
	            parent.appendChild(Ndiv);
			}
			else
			{
				if(asyncrhone == 1)
				{
					this.Send(ChangedControl.parentNode);
				}
				else
				{
					ChangedControl.parentNode.innerHTML = this.Send();
				}
			}

			//Si demande de fermeture de popup
			if(property["ClosePopup"] == true)
			{
				//Recuperation de limage de close
				var btnClosePopUp = document.getElementById('btnClosePopUp');
				btnClosePopUp.click();

				//ClosePopUp();
			}
		};

	this.Reactive = function()
	{
		var ChangedControl = document.getElementById(property["ChangedControl"]);
		ChangedControl.innerHTML = property["Text"];
		ChangedControl.className = "";
	};

	this.Send=function(control)
	{
	  var JAjax = new ajax();
	  JAjax.data = this.data;

	  if(asyncrhone == 1)
	  {
	  	JAjax.mode = "A";
	  	JAjax.Control = control;
	  }

	  return JAjax.GetRequest(this.page);
	};
};

//********************Objet Ajax **********************

ajax = function()
  {
  //propri�tes
   var requete='';
   this.method='post';
   this.mode='s';
   this.data="";
   this.RetunData="";
   this.Control ="";

   //creation de la requete
   this.CreateRequete=function()
	  {
	    if (window.XMLHttpRequest)
	    {
	         requete = new XMLHttpRequest();
	    }
	    else if (window.ActiveXObject)
	    {
	          requete = new ActiveXObject("Msxml2.XMLHTTP");
	    }
	    else
	    {
	         requete = new ActiveXObject("Microsoft.XMLHTTP");
	    }
	  };

	//envoi de la requete
	this.GetRequest=function(fichier)
  	{

  		this.CreateRequete();
  		typef = fichier.substring(fichier.indexOf("."));

		//selection du type de methode
    	if(this.method=='get')
		{
			methode="GET";
			donnees=null;
	    }
    	else
      	{
	    	  methode="POST";
			      donnees=this.datas;
     	}
		//selection du mode
	    if (this.mode=='s')
	    {
	    	modes=false;
	    }
	    else
	    {
	    	modes=true;
	    }

	//envoi de la requete
  	requete.open(methode,fichier,modes);

	//affichage en fonction du mode
  	if (this.mode=='s')
    {
   		requete.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
                requete.send(this.data);
  		return select();
    }
    else
    {
    	//alert(this.Control);
    	requete.control = this.Control;

   		requete.onreadystatechange = function ()
   		{
			if(requete.readyState==4)
		      {
		        if(requete.status !=500 && requete.status !=400)
		        {
		    	  	requete.control.innerHTML = select();
                        }
		      }
   		};

   		requete.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
   		requete.send(this.data);
    };


	this.test = function ()
	{
		alert('ok');
	};

	//action appele en most asychrone
	this.actionrequete = function()
	{
		if(requete.readyState==4)
		      {
		        if(requete.status !=500 && requete.status !=400)
		        {
		        	block.innerHTML=select();
		        }
		      }
	};

 	function select()
 	{
            if (typef=='.xml')
            {
            	type=requete.responseXML;
            }
            else
             {
            	type=requete.responseText;
             }
 		return type;
 	}
  };

  this.Refresh = function(url,classe,methode)
  {
  	control = new Array();

  	if(url.indexOf('?')>0)
 	{
		controls = serialization.Decode32(this.GetRequest(url+"&CallType=Ajax&Action="+methode));
	}
	else
	{
		controls = serialization.Decode32(this.GetRequest(url+"?CallType=Ajax&Action="+methode));
	}

	for(control  in controls)
	{
		var ctr = document.getElementById(control);

		if(ctr != null)
		{
			var parent = ctr.parentNode;
			var Ndiv = document.createElement("div" );
			Ndiv.id = control;
            Ndiv.innerHTML = controls[control];
            parent.removeChild(ctr);
            parent.appendChild(Ndiv);
		}
	}
  };

  this.RefreshModule = function(classe,methode,argument)
  {
     arg=new Array();
	 arg = serialization.Decode(argument);

	 var JAjax = new ajax();
	 JAjax.data = "Class="+classe+"&Methode="+methode;
	 JAjax.data +="&Type=Module";

	 for(ar in arg)
     {
  		 this.data += "&"+ar+"="+arg[ar];
	 }

	 controls = serialization.Decode32(JAjax.GetRequest("Ajax.php?"+argument));

	for(control  in controls)
	{
		var ctr = document.getElementById(control);

		if(ctr != null)
		{
			var parent = ctr.parentNode;
			var Ndiv = document.createElement("div" );
            Ndiv.innerHTML = controls[control];
            parent.removeChild(ctr);
            parent.appendChild(Ndiv);
		}
	}
  };
};
