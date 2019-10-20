var Map = function() {};

	/*
	* Chargement de l'application
	*/
	Map.Load = function(parameter)
	{
		this.LoadEvent();
	};

	/*
	* Chargement des �venements
	*/
	Map.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Map.Execute, "", "Map");
		Dashboard.AddEventWindowsTool("Map");
	};

   /*
	* Execute une fonction
	*/
	Map.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Map");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Map.Comment = function()
	{
		Dashboard.Comment("Map", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Map.About = function()
	{
		Dashboard.About("Map");
	};

	/*
	*	Affichage de l'aide
	*/
	Map.Help = function()
	{
		Dashboard.OpenBrowser("Map","{$BaseUrl}/Help-App-Map.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Map.ReportBug = function()
	{
		Dashboard.ReportBug("Map");
	};

	/*
	* Fermeture
	*/
	Map.Quit = function()
	{
		Dashboard.CloseApp("","Map");
	};

	/**
	 * Initialise la map
	 */
	Map.Init = function()
	{
		// On initialise la latitude et la longitude de Paris (centre de la carte)
		var lat = 48.852969;
		var lon = 2.349903;
		var macarte = null;

		// Nous initialisons une liste de marqueurs
		var markers = document.getElementById("hdMarkers");
		var villes = JSON.parse(markers.value);
		
			// Créer l'objet "macarte" et l'insèrer dans l'élément HTML qui a l'ID "map"
			Map.map = L.map('map').setView([lat, lon], 11);
			// Leaflet ne récupère pas les cartes (tiles) sur un serveur par défaut. Nous devons lui préciser où nous souhaitons les récupérer. Ici, openstreetmap.fr
			L.tileLayer('https://{s}.tile.openstreetmap.fr/osmfr/{z}/{x}/{y}.png', {
				// Il est toujours bien de laisser le lien vers la source des données
				attribution: 'données © <a href="//osm.org/copyright">OpenStreetMap</a>/ODbL - rendu <a href="//openstreetmap.fr">OSM France</a>',
				minZoom: 1,
				maxZoom: 20
			}).addTo(Map.map);
				
		for (var i =0; i< villes.length; i++) {

			if(villes[i].Lon != null)
			{
				var marker = L.marker([villes[i].Lon, villes[i].Lat]).addTo(Map.map);
				var html = "<h1>"+ villes[i].Name+"</h1><p>"+ villes[i].Description +"</p>";
					html += "<a target='_blank' href='"+villes[i].Url +"'>Découvrir ce quartier</a>";
				marker.bindPopup(html);
			}
			// Nous ajoutons la popup. A noter que son contenu (ici la variable ville) peut être du HTML
			//
		}      
	};