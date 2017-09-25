var Blog = function() {};

	/*
	* Chargement de l'application
	*/
	Blog.Load = function(parameter)
	{
             Dashboard.AddEventAppMenu(Blog.Execute, "", "Blog");
		Dashboard.AddEventWindowsTool("Blog");

                parameter = serialization.Decode(parameter);

                Blog.blogId = parameter['blogId'];
	 	Blog.ReturnedFunction = parameter['ReturnedFunction'];

		this.LoadEvent();

                if(typeof(Blog.blogId)  != "undefined")
                {
                    BlogAction.LoadBlog( Blog.blogId);
                }
                else
                {
                    //Charge les documentulaires de l'utilisateur
                      BlogAction.LoadMyBlog();
	        }
        };

	/*
	* Chargement des �venements
	*/
	Blog.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Blog.Execute, "", "Blog");
		Dashboard.AddEventWindowsTool("Blog");
        };

        /*
	* Execute une fonction
	*/
	Blog.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Blog");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Blog.Comment = function()
	{
		Dashboard.Comment("Blog", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Blog.About = function()
	{
		Dashboard.About("Blog");
	};

	/*
	*	Affichage de l'aide
	*/
	Blog.Help = function()
	{
		Dashboard.OpenBrowser("Blog","{$BaseUrl}/Help-App-Blog.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Blog.ReportBug = function()
	{
		Dashboard.ReportBug("Blog");
	};

	/*
	* Fermeture
	*/
	Blog.Quit = function()
	{
		Dashboard.CloseApp("","Blog");
	};

        /*
         * Evenement
         */
        BlogAction = function(){};

        /**
         * Pop in d'ajout de blog
         * @returns {undefined}
         */
        BlogAction.ShowAddBlog = function()
        {
            var param = Array();
                param['App'] = 'Blog';
                param['Title'] = 'Blog.ShowAddBlog';

                Dashboard.OpenPopUp('Blog','ShowAddBlog', '','','', 'BlogAction.LoadMyBlog()', serialization.Encode(param));
        };

        /**
         * Chage les blogs de l'utilisateur
         * @returns {undefined}
         */
        BlogAction.LoadMyBlog = function()
        {
           var data = "Class=Blog&Methode=LoadMyBlog&App=Blog";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Blog");
        };

        /**
         * Charge un blog
         * @param {type} blogId
         * @returns {undefined}
         */
        BlogAction.LoadBlog = function(blogId)
        {
          var data = "Class=Blog&Methode=LoadBlog&App=Blog";
              data += "&blogId=" + blogId ;
              Dashboard.LoadControl("dvDesktop", data, "" , "div", "Blog");

              BlogAction.Tab = new Array();

              //Memorisation du blog
              BlogAction.BlogId = blogId;

              //Charge les image du blog
               BlogAction.ReloadImage();
        };


        /**
         * Pop in d'ajout de catégorie
         */
        BlogAction.ShowAddCategory = function(blogId, categoryId)
        {
            var param = Array();
                param['App'] = 'Blog';
                param['Title'] = 'Blog.ShowAddCategory';
                param['blogId'] = blogId;

                if(categoryId != undefined)
                    param['CategoryId'] = categoryId;

                Dashboard.OpenPopUp('Blog','ShowAddCategory', '','','', 'BlogAction.RefreshCategory('+blogId+')', serialization.Encode(param));
        };

        /**
         * Recharge les catégories du blog
         **/
        BlogAction.RefreshCategory = function(blogId)
        {
           var data = "Class=Blog&Methode=RefreshCategory&App=Blog";
               data += "&blogId=" + blogId;

               Dashboard.LoadControl("tab_1", data, "" , "div", "Blog");
        };

        /**
         * Popin de creation d'article
         * @returns {undefined}
         */
        BlogAction.ShowAddArticle = function(blogId)
        {
            var param = Array();
                param['App'] = 'Blog';
                param['Title'] = 'Blog.ShowAddArticle';
                param['blogId'] = blogId;

                Dashboard.OpenPopUp('Blog','ShowAddArticle', '','','', 'BlogAction.LoadArticle('+blogId+')', serialization.Encode(param));
        };


        /**
         * Rafraichit la liste des articles
         * @param {type} blogId
         * @returns {undefined}
         */
        BlogAction.LoadArticle = function(blogId)
        {
           var data = "Class=Blog&Methode=LoadArticles&App=Blog";
               data += "&blogId=" + blogId;

               Dashboard.LoadControl("lstArticles", data, "" , "div", "Blog");
        };

        /**
         * Edite les propriete d'un blog
         * @type type
         */
        BlogAction.EditPropertyArticle =function(blogId, articleId)
        {
            BlogAction.ArticleId = articleId;

            var param = Array();
                param['App'] = 'Blog';
                param['Title'] = 'Blog.ShowAddArticle';
                param['articleId'] = articleId;

                Dashboard.OpenPopUp('Blog','ShowAddArticle', '','','', 'BlogAction.LoadArticle('+blogId+')', serialization.Encode(param));
        };

        /**
         * Edite un article
         * @param {type} articleId
         * @returns {undefined}
         */
        BlogAction.EditArticle = function(articleId, name)
        {
            //ouvre l'article dans une pop up
            if(typeof(BlogAction.Tab) == "undefined")
            {
                var param = Array();
                    param['App'] = 'Blog';
                    param['Title'] = 'Blog.OPenArticle';
                    param['articleId'] = articleId;
                    param['Top'] = "100px";

                Dashboard.OpenPopUp('Blog','OpenArticle', '','800','600', '', serialization.Encode(param));
            }
            else
            {
                //Verification que l'on ne la pas déjà ajouter
               for (i=0 ; i < BlogAction.Tab.length ; i++ )
               {
                   if(BlogAction.Tab[i] == name)
                   {
                       return;
                   }
               }

               //Recuperation du tabStrip
               var tsFile = document.getElementById("tbBlog");
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
                  JAjax.data = "App=Blog&Methode=EditArticle";
                  JAjax.data += "&ArticleId=" + articleId;

               var contenu = JAjax.GetRequest("Ajax.php");
               div.innerHTML = BlogAction.FormatDataForClient(contenu);

               tsFile.appendChild(div);

               TabStrip.ShowTab(newTab, 'tab_'+id+'', 10, "Blog");

                BlogAction.Tab.push(name);


            }

                            //Initialisation dez l'editeur
             //   CKEDITOR.disableAutoInline = true;
               var editor = CKEDITOR.replace( 'tbContentArticle_' + articleId  );

               CKEDITOR.setApp("BlogAction");
        }

        /**
         * Retrouve l'ongelt actif
         * @returns {undefined}
         */
        BlogAction.findTabSelected = function()
        {
            var tb = document.getElementById('tbBlog');

            if(tb != "")
            {
                dv = tb.getElementsByTagName("div");

                for(i = 0; i <  dv.length; i++ )
                {
                    if(dv[i].id.indexOf("tab")   > -1  && dv[i].style.display == "block" )
                    {
                       return dv[i];
                    }
                }
            }
            else
            {
                dvArticle = document.getElementById("dvArticle");

                return dvArticle;
            }
        };

        /**
         * Sauvegarde le contenu
         * @returns {undefined}
         */
        BlogAction.saveContent = function()
        {
            //Recuyeration de l'onglet selectionné
            dvContent = BlogAction.findTabSelected();

            //Recuêration du contenu
            txtContent = dvContent.getElementsByTagName("textarea");
            content = eval("CKEDITOR.instances." + txtContent[0].id+".getData()");

            //Recuperation de l'identifiant dez l'article
            controls = dvContent.getElementsByTagName("input");

            for(i= 0; i < controls.length; i++)
            {
                if(controls[i].type == "hidden")
                {

                    var articleId = controls[i].value;
                }
            }

            //Sauvegarde
            var JAjax = new ajax();
               JAjax.data = "App=Blog&Methode=UpdateContent";
               JAjax.data += "&ArticleId=" + articleId;
               JAjax.data += "&content=" + BlogAction.FormatDataForServeur(content);

            alert(JAjax.GetRequest("Ajax.php"));
        };

        /**
         *
         * @returns {String}Obitent le bouton de telechargement de fichier
         */
        BlogAction.getUploadButton = function()
        {
            $html = "<div>";

            $html +="<input type='file' id='fileUpload' name='fileUpload' />";
            $html += "<input type='button' value='Envoyer' onclick='upload.doUpload(this)' /> ";

            $html += "<input type='hidden' id='hdApp' name = 'hdApp'  value='Blog'  /> ";
            $html += "<input type='hidden' id='hdIdElement' name='hdIdElement' value='"+BlogAction.BlogId+"' /> ";
            $html += "<input type='hidden' id='hdCallBack' name='hdCallBack' value='BlogAction.ReloadImage();' /> ";
            $html += "<input type='hidden' id='hdAction' name='hdAction' value='UploadImageBlog' /> ";
            $html += "<input type='hidden' id='hdIdUpload'  name='hdIdUpload' value='' /> ";

            //Frame From Upload
            if(1== 2)
            {
                     $html += "<iframe id='frUpload' src='upload' style='display:block' >";
            }
            else
            {
                    $html += "<iframe id='frUpload' src='upload' style='display:none' >";
            }

            $html += "</iframe>";
            $html += "</div>";

            return $html;

        };

        /**
         *
         * @returns {undefined}enoit l'image sur le serveur
         */
        BlogAction.upload = function()
        {
            UploadAjaxFile.Upload('BlogAction.ReloadImage()', 'fileToUpload');

            ;
        };

        /**
         * Recharge la bibliothèque d'image
         * @returns {undefined}
         */
        BlogAction.ReloadImage = function()
        {
            var JAjax = new ajax();
               JAjax.data = "App=Blog&Methode=GetImages";
               JAjax.data += "&BlogId=" + BlogAction.BlogId;

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

                 /**
         * Remplace les caractères spéciaux
         */
        BlogAction.FormatDataForServeur = function(data)
        {
            var myRegEx=new RegExp("&", "gm");
                data= data.replace(myRegEx , "!et!");

            return data;
        };

        /**
         * Remplace les caractères speciaux
         */
        BlogAction.FormatDataForClient = function(data)
        {
          var myRegEx=new RegExp("!et!", "gm");
             data= data.replace(myRegEx , "&");

            return data;
        };

        /**
         * Rafraichit l'image de l'article
         * @returns {undefined}
         */
        BlogAction.RefreshImageArticle = function()
        {
            var dvImageArticle = document.getElementById("dvImageArticle");

            var JAjax = new ajax();
                JAjax.data = "App=Blog&Methode=GetImageArticle";
                JAjax.data += "&ArticleId=" + BlogAction.ArticleId;

             dvImageArticle.innerHTML = JAjax.GetRequest("Ajax.php");
         };

         /*
          * Affiche les commentaires sur un article
          *
          */
         BlogAction.ShowComment = function(articleId)
         {
            var param = Array();
                param['App'] = 'Blog';
                param['Title'] = 'Blog.ShowComment';
                param['articleId'] = articleId;

                Dashboard.OpenPopUp('Blog','ShowComment', '','','', '', serialization.Encode(param));
         };

         /**
          * Publie/Depublie un commentaire
          * @param {type} commentId
          * @param {type} state
          * @returns {undefined}
          */
         BlogAction.Publish = function (control, commentId, state)
         {
             //Nouvau boutton
            var container = control.parentNode;
            var newButton = "<input type='button' ";
                newButton += " class='btn btn-primary' ";

            container.removeChild(control);

            //Sauvagarde ajax
            var JAjax = new ajax();
                JAjax.data = "App=Blog&Methode=PublishComment";
                JAjax.data += "&commentId=" + commentId;
                JAjax.data += "&state=" + state;

                JAjax.GetRequest("Ajax.php");

            if(state == 1)
            {
                newButton += "value='unpublish' ";
                newButton += " onclick ='BlogAction.Publish(this, "+commentId+", 0)' >";
            }
            else
            {
                newButton += "value='publish' ";
                newButton += " onclick ='BlogAction.Publish(this, "+commentId+", 1)' >";
            }

            container.innerHTML += newButton;
         };

        /*
         * Synchronise le blog sur le site distant
         * Pour l'instant les images
         * TODO Gérer un site complet externe
         */
         BlogAction.Synchronise = function(blogId)
         {
             var jbBlog = document.getElementById("jbBlog");

             var JAjax = new ajax();
                JAjax.data = "App=Blog&Methode=Synchronise";
                JAjax.data += "&BlogId=" + blogId;

               jbBlog.innerHTML += JAjax.GetRequest("Ajax.php");
         };

        /*
        Ajoute le commentaire
        */
        BlogAction.AddComment = function(code)
        {
           var dvComment = document.getElementById("dvAddComment");

            var tbEmail = document.getElementById("tbEmail");    
            var tbName = document.getElementById("tbName");    
            var tbComment = document.getElementById("tbComment");    

            if(tbComment.value != "")
            {

            var JAjax = new ajax();
                JAjax.data = "App=Blog&Methode=AddComment";
                JAjax.data += "&code=" + code;
                JAjax.data += "&tbEmail=" + tbEmail.value;
                JAjax.data += "&tbName=" + tbName.value;
                JAjax.data += "&tbComment=" + tbComment.value;

               dvComment.innerHTML = JAjax.GetRequest(Dashboard.GetPath("Ajax.php"));
           }
           else
           {
               alert(Dashboard.GetCode("Blog.MustAddMessage"))
           }
        };
        
        /*
         * Inscription newsLetter
         */
        Blog.AddEmailNews = function(blogId)
        {
            var dvNewsLetter = document.getElementById("dvNewsLetter");
             var tbEmailNews = document.getElementById("tbEmailNews");  
             
             if(tbEmailNews.value != "")
             {
              var JAjax = new ajax();
                JAjax.data = "App=Blog&Methode=AddEmailNews";
                JAjax.data += "&BlogId=" + blogId;
                JAjax.data += "&tbEmailNews=" + tbEmailNews.value;
                
                dvNewsLetter.innerHTML = JAjax.GetRequest(Dashboard.GetPath("Ajax.php"));
             }
             else
             { 
                 alert(Dashboard.GetCode("Blog.MustAddEmailNews"))
             }
        }
