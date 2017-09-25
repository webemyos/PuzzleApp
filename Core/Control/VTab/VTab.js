var VTab = new VTab();


function VTab()
{
	//Affichage d'un onglet
	this.ShowTab = function(onglet, tabId, nbOnglet, name)
	{
           // alert('ici');
            
		tab=document.getElementById(tabId);

		if(tab != null)
		{
			//reinitialisation de tous les onglets
			for(i=0;i<10;i++)
			{
			 	tabs=document.getElementById(name + '_vtab_'+i);

				if(tabs != null && tabs.id != tabId)
				{
				 tabs.style.height='0px';
				 tabs.style.display = 'none';

				 index=document.getElementById(name + '_vindex_'+i);
				 index.className ="VTabStripDisabled";
				}
			}
                        
                       // alert(onglet.className);
                        
                        //si il est ouvert on le ferme
                        if( onglet.className == "VTabStripDisabled")
                         {
                           onglet.className ="VTabStripEnabled";

                            tab.style.height='auto';
                            tab.style.display = 'block';
                            
                            
                         }
                         else
                         {
                            onglet.className ="VTabStripDisabled";

                            tab.style.height='0px';
                            tab.style.display = 'none';
                         }
		}
	};

	this.Close = function(numeroOnglet)
	{
		//alert(onglet);
		var onglet = document.getElementById('vindex_'+ numeroOnglet);
		var div = document.getElementById('vtab_'+ numeroOnglet);

		onglet.parentNode.removeChild(onglet);
		div.parentNode.removeChild(div);

		var onglet = document.getElementById('vindex_0');

		this.ShowTab(onglet, 'vtab_0', 10);

		return false;
	};
};