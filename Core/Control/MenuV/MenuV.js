var MenuV = new MenuV();

function MenuV()
{
	this.openSubMenu = function(element, e, name)
	{
		//on remonte jusqu'au parent
		while(e.id.indexOf(name) == -1)
		{
			e = e.parentNode;
		}

		//On recupere la diov a ouvrir
		var controls = e.getElementsByTagName("div");

		for(i=0; i < controls.length; i++)
		{
			if(controls[i].id == element)
			{
				var submenu = controls[i];
				break;
			}
		}

	   if(submenu != null)
		{
			//submenu.className= "appSubMenu";
			submenu.style.overflow ="visible";
			submenu.style.visibility ="visible";
		}
	};

	this.CloseSubMenu= function(element, e, name)
	{
		//on remonte jusqu'au parent
		while(e.id.indexOf(name) == -1  )
		{
			e = e.parentNode;
		}

		//On recupere la diov a ouvrir
		var controls = e.getElementsByTagName("div");

		for(i=0; i < controls.length; i++)
		{
			if(controls[i].id == element)
			{
				var submenu = controls[i];
				break;
			}
		}

		if(submenu != null)
		{
			//submenu.style.overflow ="hidden";
			submenu.style.visibility ="hidden";
		}
	};
};