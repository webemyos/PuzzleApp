var Mooc = function() {};

    /*
    * Chargement de l'application
    */
    Mooc.Load = function(parameter)
    {
            this.LoadEvent();

            if(parameter != "" )
            {
                MoocAction.StartMooc(parameter);
            }
    };

    /*
    * Chargement des �venements
    */
    Mooc.LoadEvent = function()
    {
            Dashboard.AddEventAppMenu(Mooc.Execute, "", "Mooc");
            Dashboard.AddEventWindowsTool("Mooc");
    };

/*
    * Execute une fonction
    */
    Mooc.Execute = function(e)
    {
            //Appel de la fonction
            Dashboard.Execute(this, e, "Mooc");
            return false;
    };

    /*
    *	Affichage de commentaire
    */
    Mooc.Comment = function()
    {
            Dashboard.Comment("Mooc", "1");
    };

    /*
    *	Affichage de a propos
    */
    Mooc.About = function()
    {
            Dashboard.About("Mooc");
    };

    /*
    *	Affichage de l'aide
    */
    Mooc.Help = function()
    {
            Dashboard.OpenBrowser("Mooc","{$BaseUrl}/Help-App-Mooc.html");
    };

/*
    *	Affichage de report de bug
    */
    Mooc.ReportBug = function()
    {
            Dashboard.ReportBug("Mooc");
    };

    /*
    * Fermeture
    */
    Mooc.Quit = function()
    {
            Dashboard.CloseApp("","Mooc");
    };

    //Evenement
    MoocAction = function(){};

    /**
     * Charge la partie administration
     * @returns 
     */
    MoocAction.LoadAdmin = function()
    {
       var data = "Class=Mooc&Methode=LoadAdmin&App=Mooc";
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Mooc");   
    };

    /*
     * Pop in da'jout de catégorie de Mooc
     * @param {type} categoryId
     * @returns {undefined}
     */
    MoocAction.ShowAddCategory = function(categoryId)
    {
             var param = Array();
            param['App'] = 'Mooc';
            param['Title'] = 'Mooc.ShowAddCategory';
            
            if(categoryId != undefined)
            {
                param['CategoryId'] = categoryId;
            }
            
            Dashboard.OpenPopUp('Mooc','ShowAddCategory', '','','', 'MoocAction.RefreshCategory()', serialization.Encode(param));
    };

    /**
     * Recharge les catégories du blog
     **/
    MoocAction.RefreshCategory = function()
    {
       var data = "Class=Mooc&Methode=RefreshCategory&App=Mooc";
           Dashboard.LoadControl("tab_0", data, "" , "div", "Mooc"); 
    };

    /*
     * Ecran de gestion des mooc de l'utilisateur
     */
    MoocAction.LoadPropose =function()
    {
         var data = "Class=Mooc&Methode=LoadPropose&App=Mooc";
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Mooc"); 

        MoocAction.Tab = Array();
    };

    /**
     * Popin de créatin d'un mooc
     * @returns {undefined}
     */
    MoocAction.ShowAddMooc = function( moocId)
    {
        var param = Array();
            param['App'] = 'Mooc';
            param['Title'] = 'Mooc.ShowAddMooc';
            
            if(moocId != undefined)
            {
                param['MoocId'] = moocId;
            }
            
            Dashboard.OpenPopUp('Mooc','ShowAddMooc', '','','', 'MoocAction.LoadPropose()', serialization.Encode(param));

            Dashboard.SetAdvancedText("tbMoocDescription");
    };

    /*
     * Edites les leçons d'un Mooc 
     */
    MoocAction.EditMooc = function(moocId, name)
    {
         MoocAction.MoocId = moocId;

         //Verification que l'on ne la pas déjà ajouter
           for (i=0 ; i < MoocAction.Tab.length ; i++ )
           {
               if(MoocAction.Tab[i] == name)
               {
                   return;
               }
           }

           //Recuperation du tabStrip
           var tsFile = document.getElementById("tabMooc");
           var th = tsFile.getElementsByTagName("th");

           //Recuperation du dernier onglet
           var lastTab = th[th.length-1];

           var idTab = lastTab.id.split("_");
           var id = idTab[1];
           id++;

           var newTab = document.createElement("th");

           newTab.innerHTML = name  ;
           newTab.name = name ;
           newTab.id = "index_" + id;
           newTab.className = "TabStripDisabled";
           newTab.title = name ;
           var click = function(){ TabStrip.ShowTab(this,'tab_'+id+'',id);};

           Dashboard.AddEvent(newTab, "click", click);

           //Ajout de l'onglet
           (th[0]).parentNode.appendChild(newTab);

           //Ajout de la div correspondante
           var div = document.createElement("div");
           div.id = "tab_"+id+"";
           div.style.overflow = 'hidden';
           div.style.display = 'none';

           div.innerHTML = "Loading ...";
           var JAjax = new ajax();
              JAjax.data = "App=Mooc&Methode=EditMooc";
              JAjax.data += "&moocId=" + moocId;

           var contenu = JAjax.GetRequest("Ajax.php");
           div.innerHTML = contenu;

           tsFile.appendChild(div);

           TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Mooc");

            MoocAction.Tab.push(name);

             //Charge les image du blog
           MoocAction.ReloadImage();
    };

    /*
     * Pop in d'ajout/Modification d'une lesson
     */
    MoocAction.ShowAddLesson = function(moocId, lessonId, name)
    {
        //Verification que l'on ne la pas déjà ajouter
           for (i=0 ; i < MoocAction.Tab.length ; i++ )
           {
               if(MoocAction.Tab[i] == name)
               {
                   return;
               }
           }

           //Recuperation du tabStrip
           var tsFile = document.getElementById("tabMooc");
           var th = tsFile.getElementsByTagName("th");

           //Recuperation du dernier onglet
           var lastTab = th[th.length-1];

           var idTab = lastTab.id.split("_");
           var id = idTab[1];
           id++;

           var newTab = document.createElement("th");

           newTab.innerHTML = name  ;
           newTab.name = name ;
           newTab.id = "index_" + id;
           newTab.className = "TabStripDisabled";
           newTab.title = name ;
           var click = function(){ TabStrip.ShowTab(this,'tab_'+id+'',id);};

           Dashboard.AddEvent(newTab, "click", click);

           //Ajout de l'onglet
           (th[0]).parentNode.appendChild(newTab);

           //Ajout de la div correspondante
           var div = document.createElement("div");
           div.id = "tab_"+id+"";
           div.style.overflow = 'hidden';
           div.style.display = 'none';

           div.innerHTML = "Loading ...";
           var JAjax = new ajax();
              JAjax.data = "App=Mooc&Methode=ShowAddLesson";
              JAjax.data += "&moocId=" + moocId;

            if(lessonId != undefined)
            {
                JAjax.data += "&lessonId=" + lessonId;
            }
        
           var contenu = JAjax.GetRequest("Ajax.php");
           div.innerHTML = contenu;

           tsFile.appendChild(div);

           TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Mooc");

            MoocAction.Tab.push(name);

            //Initialisation dez l'editeurEditeur avancé
             if(lessonId != undefined)
            {
                Dashboard.SetAdvancedText("tbLessonContent_" + lessonId);
            }
            else
            {
                Dashboard.SetAdvancedText("tbLessonContent_");
            }
            
            CKEDITOR.setApp("MoocAction");
    };

   /*
    * Sauvegare une lesson
    * @param {type} lessonId
    * @returns {undefined}
    */
   MoocAction.SaveLesson = function($moocId, lessonId)
   {
       if(lessonId == undefined)
       {
           lessonId = "";
       }
       
       
       //recuperation des elemement
       var tbLessonName = document.getElementById("tbLessonName_" + lessonId );
       var tbLessonVideo = document.getElementById("tbLessonVideo_" + lessonId );
       var cbActif = document.getElementById("cbActif_" + lessonId );
       var tbLessonDescription = document.getElementById("tbLessonDescription_" + lessonId );
       var tbLessonContent = document.getElementById("tbLessonContent_" + lessonId );
       
       
         var data = "Class=Mooc&Methode=SaveLesson&App=Mooc";
             data += "&moocId=" + $moocId;
             data += "&lessonId=" + lessonId;
             data += "&name=" + tbLessonName.value;
             data += "&video=" + tbLessonVideo.value;
             data += "&actif=" + cbActif.checked;
             data += "&description=" + tbLessonDescription.value;
             data += "&content=" + MoocAction.FormatDataForServeur(tbLessonContent.value);

       Dashboard.LoadControl("jbLesson_" + lessonId , data, "" , "div", "Mooc"); 


        //Initialisation dez l'editeurEditeur avancé
        Dashboard.SetAdvancedText("tbLessonContent_" + lessonId);

   };

     /**
     * Remplace les caractères spéciaux
     */
    MoocAction.FormatDataForServeur = function(data)
    {
        var myRegEx=new RegExp("&", "gm");
            data= data.replace(myRegEx , "!et!");

        return data;
    };

    /**
     * Remplace les caractères speciaux
     */
    MoocAction.FormatDataForClient = function(data)
    {
      var myRegEx=new RegExp("!et!", "gm");
         data= data.replace(myRegEx , "&");

        return data;
    };

   /*
    * Obtient le bouton d'upload d'image
    * @returns {String}
    */
   MoocAction.getUploadButton = function()
   {
       return Dashboard.GetUploadButton("Mooc", MoocAction.MoocId, "MoocAction.ReloadImage()","UploadImageMooc",true);
   };

     /**
     * 
     * @returns {undefined}enoit l'image sur le serveur
     */
    MoocAction.upload = function()
    {
        UploadAjaxFile.Upload('MoocAction.ReloadImage()', 'fileToUpload');
    };

     /**
     * Recharge la bibliothèque d'image
     * @returns {undefined}
     */
    MoocAction.ReloadImage = function()
    {
        var JAjax = new ajax();
           JAjax.data = "Class=Mooc&Methode=GetImages&App=Mooc";
           JAjax.data += "&moocId=" + MoocAction.MoocId;

        lstImage = JAjax.GetRequest("Ajax.php").split(";");

        var vTypeOf = typeof(CKEDITOR);
        if(vTypeOf == 'object') 
        {    
            CKEDITOR.config.tabbedimages  = lstImage[0].split(",");
            CKEDITOR.config.tabbedthumbimages = lstImage[1].split(",");
            if (typeof ReplaceDSbrowserHTML == 'function') { 
                 ReplaceDSbrowserHTML(); 
            }
        }
     };

    /*
     * Ecran de gestion de recherche de Mooc
     */
    MoocAction.LoadSearch = function()
    {
         var data = "Class=Mooc&Methode=LoadSearch&App=Mooc";
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Mooc"); 

        MoocAction.Tab = Array();
    };

    /*
     * Recherche les mooc
     */
    MoocAction.Search = function()
    {
        var lstCategory = document.getElementById("lstCategory");

         var data = "Class=Mooc&Methode=Search&App=Mooc";
             data += "&categoryId=" + lstCategory.value;

           Dashboard.LoadControl("lstMooc", data, "" , "div", "Mooc"); 
    };

    /*
     * Lance le mooc
     */
    MoocAction.StartMooc = function(moocId)
    {
            var data = "Class=Mooc&Methode=StartMooc&App=Mooc";
                data += "&moocId=" + moocId;
           Dashboard.LoadControl("dvDesktop", data, "" , "div", "Mooc"); 
    };

    /*
     * Charge une lesson
     */
    MoocAction.LoadLesson = function(lessonId)
    {
            var data = "Class=Mooc&Methode=LoadLesson&App=Mooc";
                data += "&lessonId=" + lessonId;

           Dashboard.LoadControl("dvLesson", data, "" , "div", "Mooc"); 
    };

    /*
     * Pop in pour ajouter un element
     * @param {type} lessonId
     * @returns {undefined}
     */
    MoocAction.ShowAddElement = function(lessonId)
    {
        var param = Array();
            param['App'] = 'Mooc';
            param['Title'] = 'Mooc.ShowAddElement';
            param['lessonId'] = lessonId;

            Dashboard.OpenPopUp('Mooc','ShowAddElement', '','','', 'MoocAction.RefreshElement(' + lessonId+ ')', serialization.Encode(param));

    };

    /*
     * Ajoute un element à la lesson
     * @param {type} lessonId
     * @returns {undefined}
     */
    MoocAction.AddElement = function(lessonId)
    {
        var dvAddElement = document.getElementById("dvAddElement");
        var lstTypeElement = document.getElementById("lstTypeElement");
        var tbNameElement = document.getElementById("tbNameElement");

           var JAjax = new ajax();
              JAjax.data = "App=Mooc&Methode=AddElement";
              JAjax.data += "&lessonId=" + lessonId;
              JAjax.data += "&typeElement=" + lstTypeElement.value;
              JAjax.data += "&nameElement=" + tbNameElement.value;

         dvAddElement.innerHTML =  JAjax.GetRequest("Ajax.php");

           //Rafhaichit
           MoocAction.RefreshElement(lessonId);
    };

    /*
     * Rafraichit les elements
     * @type type
     */
    MoocAction.RefreshElement = function(lessonId)
    {
        var dvElement = document.getElementById("dvElement_" + lessonId);
            var JAjax = new ajax();
              JAjax.data = "App=Mooc&Methode=RefreshElement";
              JAjax.data += "&lessonId=" + lessonId;

         dvElement.innerHTML = JAjax.GetRequest("Ajax.php");
    };

    /*
     * Ajout d'un quizz (Form)
     */
    MoocAction.ShowAddQuiz = function(moocId)
    {
               var param = Array();
            param['App'] = 'Mooc';
            param['Title'] = 'Mooc.NewQuiz';
            param['MoocId'] = moocId;

            Dashboard.OpenPopUp('Mooc','ShowAddQuiz', '','','', 'MoocAction.RefreshLesson('+ moocId +')', serialization.Encode(param));
    };

    /**
     * Edit une quiz 
     */
    MoocAction.EditQuiz = function(moocId, quizzId)
    {
     var parameter = Array();
        parameter["formId"] = quizzId;
        parameter["ReturnedFunction"] = 'MoocAction.RefreshLesson('+ moocId +')';
        Dashboard.StartApp("", "Form", ''+serialization.Encode(parameter)+'');
    };

    /*
    * Charge un quiz
    */
    MoocAction.LoadQuiz = function(quizId)
    {
          var data = "Class=Mooc&Methode=LoadQuiz&App=Mooc";
              data += "&quizId=" + quizId;

         Dashboard.LoadControl("dvLesson", data, "" , "div", "Mooc"); 
    };

    /*
     * Charge les Mooc de l'utilisateur
     */
    MoocAction.LoadMyLesson = function()
    {
      var data = "Class=Mooc&Methode=LoadMyLesson&App=Mooc";

      Dashboard.LoadControl("dvDesktop", data, "" , "div", "Mooc"); 
    };
        