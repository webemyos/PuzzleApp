var serialization = new Serialization();

/**
 * Fonction de serialisations des données
 * @returns {Serialization}
 */
function Serialization()
{
	/**
         * Encode le tableau en une chaine de caractère
         * @param {type} tableau
         * @returns {String}
         */
        this.Encode = function(tableau)
	{
		var chaine ="";

		for(tab in tableau)
		{
			chaine	+= "::"+tab + "!!"+tableau[tab];
		}
		return chaine;
	};

        /**
         * Decode la chaine en un tableau Propriéte => Valeur
         * @param {type} chaine
         * @returns {Array}
         */
	this.Decode = function (chaine)
	{
		var args = chaine.split("::");
		var property = new Array();

		for(i=0;i<args.length;i++)
		{
                    prop = args[i].split("!!");
                    property[prop[0]]=prop[1];
		}

		return property;
	};

	this.Decode32 = function (chaine)
	{
		var args = chaine.split("^");
		var property = new Array();

			for(i=0;i<args.length;i++)
			{
				prop = args[i].split("|");
				property[prop[0]]=prop[1];
			}

		return property;
	};


	this.Decript = function(code)
	{
		cript ="";
		if(code != null )
		{
			for(j=0;j<=code.length ; j++)
			{
			 cript += (String.fromCharCode(code.charCodeAt(j)));
			}
		}
		return cript;
	};
};
