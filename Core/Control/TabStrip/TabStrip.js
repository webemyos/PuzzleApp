var TabStrip = new TabStrip();


function TabStrip()
{
	//Affichage d'un onglet
	this.ShowTab = function(onglet, tabId, nbOnglet, appName, widgetName)
	{

		if(appName != "")
		{
			tab = Dashboard.GetElement(tabId, 'div', appName);
		}
		else
		{
			tab = document.getElementById(tabId);
		}

		if(tab != null)
		{
			//reinitialisation de tous les onglets
			for(numero=0; numero<= 10; numero++)
			{
				if(appName != "")
				{
					tabs = Dashboard.GetElement('tab_'+ numero, 'div', appName);
				}
				else
				{
			 		tabs=document.getElementById('tab_'+ numero);
				}

				if(tabs != null)
				{
					 tabs.style.height='0px';
					 tabs.style.display = 'none';

					 if(appName != "")
					 {
					 	//Recuperation du bon index
					 	index= Dashboard.GetElement('index_'+ numero, 'th', appName);
					 }
					 else
					 {
					 	index=document.getElementById('index_'+numero);
					 }

					 //index.className = "TabStripDisabled";
					index.className = index.className.replace("TabStripEnabled", "TabStripDisabled") ;
				}
			}

			//Activation du bon onglet
			onglet.className =  onglet.className.replace("TabStripDisabled", "TabStripEnabled");
			tab.style.height='auto';
			tab.style.display = 'block';
		}
	};

	this.Close = function(numeroOnglet)
	{
		//alert(onglet);
		var onglet = document.getElementById('index_'+ numeroOnglet);
		var div = document.getElementById('tab_'+ numeroOnglet);

		onglet.parentNode.removeChild(onglet);
		div.parentNode.removeChild(div);

		var onglet = document.getElementById('index_0');

		this.ShowTab(onglet, 'tab_0', 10);

		return false;
	};
};
