var Task = function() {};

	/*
	* Chargement de l'application
	*/
	Task.Load = function(parameter)
	{
    var param = serialization.Decode(parameter);
  
    if(parameter == "" || parameter == undefined)
    {
		  this.LoadEvent();
    }
    else
    {
      TaskAction.OpenProjet(param["projetId"]);
    }
	};

	/*
	* Chargement des �venements
	*/
	Task.LoadEvent = function()
	{
		Dashboard.AddEventAppMenu(Task.Execute, "", "Task");
		Dashboard.AddEventWindowsTool("Task");
                
                TaskAction.LoadMyGroup();
	};

   /*
	* Execute une fonction
	*/
	Task.Execute = function(e)
	{
		//Appel de la fonction
		Dashboard.Execute(this, e, "Task");
		return false;
	};

	/*
	*	Affichage de commentaire
	*/
	Task.Comment = function()
	{
		Dashboard.Comment("Task", "1");
	};

	/*
	*	Affichage de a propos
	*/
	Task.About = function()
	{
		Dashboard.About("Task");
	};

	/*
	*	Affichage de l'aide
	*/
	Task.Help = function()
	{
		Dashboard.OpenBrowser("Task","{$BaseUrl}/Help-App-Task.html");
	};

   /*
	*	Affichage de report de bug
	*/
	Task.ReportBug = function()
	{
		Dashboard.ReportBug("Task");
	};

	/*
	* Fermeture
	*/
	Task.Quit = function()
	{
		Dashboard.CloseApp("","Task");
	};
        
        /**
         * Evenement
         */
        TaskAction = function(){};
        
        /**
         * Ajoute un groupe de tâches
         */
        TaskAction.ShowAddGroup = function(groupId)
        {
            var param = Array();
                param['App'] = 'Task';
                param['Title'] = 'Task.ShowAddGroup';
                
                if(groupId != undefined)
                {
                    param['GroupId'] = groupId;
                }
            
                Dashboard.OpenPopUp('Task','ShowAddGroup', '','','', 'TaskAction.LoadMyGroup()', serialization.Encode(param));
        };
        
        /**
         * Charge les groupes de tâches de l'utilisateur
         */
        TaskAction.LoadMyGroup = function()
        {
           var data = "Class=Task&Methode=LoadMyGroup&App=Task";
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Task"); 
        };
        
        /**
         * Charge les taches
         */
         TaskAction.LoadTask = function(GroupId)
         {
           var data = "Class=Task&Methode=LoadTask&App=Task";
               data += "&GroupId="+GroupId;
               
               Dashboard.LoadControl("dvDesktop", data, "" , "div", "Task");   
         };
        
        /**
         * popin d'ajout de taches
         */
        TaskAction.ShowAddTask = function(groupId, taskId, appName, refreshAction)
        {
            var param = Array();
                param['App'] = 'Task';
                param['Title'] = 'Task.ShowAddTask';
                param['GroupId'] = groupId;
                param['TaskId'] = taskId;
              
              if(refreshAction != "")
              {
                action = refreshAction;
              }
              else
              {
                if(appName == "")
                {
                    action = 'TaskAction.LoadTask(' + groupId +')' ;
                }
                else
                {
                    action = appName+'Action.LoadTask(' + groupId + ')';
                }
              } 
              
            Dashboard.OpenPopUp('Task','ShowAddTask', '','','', action, serialization.Encode(param)); 
        };
        
        /**
         * Pop in d'ajout de sous taches
         */
        TaskAction.ShowAddSubTask = function(taskId, subTaskId, appName, refreshAction)
        {
            var param = Array();
                param['App'] = 'Task';
                param['Title'] = 'Task.ShowAddTask';
                param['TaskId'] = taskId;
                param['SubTaskId'] = subTaskId;
               
               if(refreshAction != "")
              {
                action = refreshAction;
              }
              else
              {
                if(appName == "")
                {
                    action ='TaskAction.LoadSubTask(' + taskId + ')';
                }
                else
                {
                    action = appName+'Action.LoadSubTask(' + taskId + ')';
                }
              }
                Dashboard.OpenPopUp('Task','ShowAddSubTask', '','','', action, serialization.Encode(param)); 
        };
       
        //Rechargement des sous taches
        TaskAction.LoadSubTask = function(taskId)
        {
               var data = "Class=Task&Methode=LoadSubTask&App=Task";
               data += "&TaskId="+ taskId;
              
               Dashboard.LoadControl("dvSubTask_" + taskId , data, "" , "div", "Task");   
        };
        
        /**
         * Supprime une tâche
         */
        TaskAction.DeleteTask = function(control, taskId, parent)
        {
            if(confirm(Dashboard.GetCode("Delete")))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=Task&App=Task&Methode=DeleteTask";
                    JAjax.data += "&TaskId=" + taskId;

                    //Execution
                    JAjax.GetRequest("Ajax.php");

                    if(parent == 1)
                    {
                       control.parentNode.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode.parentNode); 
                    }
                    else
                    {
                        control.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode);
                    }
            }
        };
            
        /**
         * Supprime un groupe
         */
        TaskAction.DeleteGroup = function(control, groupId)
        {
            if(confirm(Dashboard.GetCode("Delete")))
            {
                var JAjax = new ajax();
                    JAjax.data = "Class=Task&App=Task&Methode=DeleteGroup";
                    JAjax.data += "&GroupId=" + groupId;

                    //Execution
                    JAjax.GetRequest("Ajax.php");

              control.parentNode.parentNode.parentNode.parentNode.removeChild(control.parentNode.parentNode.parentNode); 
            }
        };
        
        /**
         * Ouvre un grouoe de tachye
         */
        TaskAction.OpenTask = function(groupId)
        {
           var param = Array();
               param['App'] = 'Task';
               param['groupId'] = groupId; 
               param['Title'] = "Task.Open";
             
                Dashboard.OpenPopUp('Task','OpenTask', '','','', ' TaskAction.LoadMyGroup()', serialization.Encode(param));
                
                //Ajout l'evenemetn clique sur les élements éditable
                $(".editable").click(function(){ TaskAction.Edit(this)});
                $(".textEditable").click(function(){ TaskAction.EditText(this)});
     
        };
        
        /**
         * Ouvre le détail d'un tache
         * @returns {undefined}
         */
        TaskAction.OpenDetail = function(control, idEntite)
        {
            var tab = document.getElementById("tab_" + idEntite);
            
            if(tab != null)
            {
                if(tab.style.display == "none")
                {
                    tab.style.display = "block";
                    control.parentNode.style.width = "100%";
                }
                else
                {
                    tab.style.display = "none"; 
                    control.parentNode.style.width = "20%";
                }
            }
        };
        /**
         * Rend un element éditable
         * 
         * @returns 
         */
        TaskAction.Edit = function(element)
        {
            //Mémorisation du control source
            TaskAction.element = element;
            
            container = element.parentNode;
              
            tbText = document.createElement("input");
            tbText.id= "tbNewValue";
            tbText.type=  "text";
            tbText.value = element.innerHTML;
            
            //Icone de sauvegarde
            icSave = document.createElement("span");
            icSave.id = "icSave";
            icSave.className = "icon-save";
            icSave.title = "save";
            icSave.ineeHTML = "&nbsp;&nbsp;";
            $(icSave).click(function(){TaskAction.update("text")});
    
            //Icone de sauvegarde
            $(element).hide();
            container.appendChild(tbText);
            container.appendChild(icSave);   
        };
        
        //Edit l'element dans une text area
        TaskAction.EditText = function(element)
        {
            //Mémorisation du control source
            TaskAction.element = element;
            
            container = element.parentNode;
            
            tbText = document.createElement("textarea");
            tbText.id= "tbNewValue";
            tbText.innerHTML = element.innerHTML;
              
            //Icone de sauvegarde
            icSave = document.createElement("span");
            icSave.id = "icSave";
            icSave.className = "icon-save";
            icSave.title = "save";
            icSave.ineeHTML = "&nbsp;&nbsp;";
            $(icSave).click(function(){TaskAction.update("textarea")});
    
            //Icone de sauvegarde
            $(element).hide();
            container.appendChild(tbText);
            container.appendChild(icSave); 
        };
        
        /**
         * Met à jour l'element
         * 
         * @returns
         */
        TaskAction.update = function(controlType)
        {
            var tbText = document.getElementById("tbNewValue");
            var icSave = document.getElementById("icSave");
            
            id= TaskAction.element.id.split("_");
            
            //Sauvegarde ajax
            var JAjax = new ajax();
                JAjax.data = "Class=Task&App=Task&Methode=UpdateElement";
                JAjax.data += "&Action="+ id[0];
                JAjax.data += "&Property="+ id[1];
                JAjax.data += "&Id=" + id[2];
               
            
            if(controlType == "text")
            {
                 //Ajout de la nouvelle valeur
                TaskAction.element.innerHTML = tbText.value;
          
                JAjax.data += "&Value="+ tbText.value;
          
            }
            else
            {
              //Ajout de la nouvelle valeur
               TaskAction.element.innerHTML = tbText.value;
               JAjax.data += "&Value="+ tbText.value;
            }
                //Execution
                JAjax.GetRequest("Ajax.php");
                    
            //Suppression des elements de saisis
            TaskAction.element.parentNode.removeChild(tbText);
            TaskAction.element.parentNode.removeChild(icSave);
            
            //Reaffichage du control
            $(TaskAction.element).show();
        };
        
        /*
         * Affiche la liste des actions à réaliser
         */
        TaskAction.ShowListAction = function(subTaskId)
        {
           TaskAction.TaskId = subTaskId;
                    
           var param = Array();
               param['App'] = 'Task';
               param['subTaskId'] = subTaskId; 
               param['Title'] = "Task.ListAction";
             
                Dashboard.OpenPopUp('Task','ShowListAction', '','','', 'TaskAction.RefreshSubTask()', serialization.Encode(param));
        };
        
        /**
         * Rafrachit la sous tâches
         * @returns {undefined}
         */
        TaskAction.RefreshSubTask = function()
        {
           var spCount = document.getElementById("spCount_" +  TaskAction.TaskId);
           
                var JAjax = new ajax();
                    JAjax.data = "Class=Task&App=Task&Methode=GetCountAction";
                    JAjax.data += "&TaskId=" + TaskAction.TaskId;
               
                    //Execution
              spCount.innerHTML = JAjax.GetRequest("Ajax.php");
        };
        
        /**
         * Ajoute un champ de saisie d'action
         * @returns {undefined}
         */
        TaskAction.AddAction = function()
        {
            var lstAction = document.getElementById("lstAction");
            
            var span = document.createElement("div");
                span.class = 'action';
            
            //Ajout d'une case à coché
            var cb = document.createElement('input');
                cb.type = "checkbox";
                span.appendChild(cb);  
            
            //Ajout d'un champ libellé
            var tb = document.createElement('textarea');
                tb.type = 'text';
                tb.style.height = "50px";
                tb.id = "tbResponseText";   
                span.appendChild(tb);  
            
            //Image de suppression
             var img = document.createElement('i');
                        img.className = 'icon-remove';
                        img.tilte = "Supprimer";
                        img.innerHTML = "&nbsp;";
                        Dashboard.AddEvent(img, "click", TaskAction.DelResponse);
                        span.appendChild(img);
                        
            lstAction.appendChild(span);
        };
        
        /**
        * Supprime une réponse
        **/
       TaskAction.DelResponse = function(e)
       {
           control = e.srcElement || e.target;
           TaskAction.DeleteResponse(control);
       };

       /*
       * Supprime la r�ponse
       *
       */
       TaskAction.DeleteResponse = function(control)
       {
               control.parentNode.parentNode.removeChild(control.parentNode);
       };
       
       /**
        * Sauvegarde les actions pour un taches
        * @returns {undefined}
        */
       TaskAction.SaveAction = function()
       {
           //Recuperation des inputs
           var lstAction = document.getElementById("lstAction");
           var actions = lstAction.getElementsByTagName("div");
           
           var data = Array();
           
           for(i=0; i < actions.length; i++)
           {
              //Recuperation des checkbox et des input
              controls = actions[i].getElementsByTagName("input");
              tbLibelle = actions[i].getElementsByTagName("textarea");
               
              action ="";
               
              for(j=0; j < controls.length; j++ )
              {
                     
                  if(controls[j].type == "checkbox" )
                  {
                      if(controls[j].checked )
                      {
                          action = 1;
                      }
                      else
                      {
                         action = 0; 
                      }
                  }
              }
             
              action +=  ":" +tbLibelle[0].value;
             
              data.push(action);
              
           }
           
            var JAjax = new ajax();
                    JAjax.data = "Class=Task&App=Task&Methode=SaveAction";
                    JAjax.data += "&TaskId=" + TaskAction.TaskId;
                    JAjax.data += "&Actions=" + data.join("!");
        
                    //Execution
              lstAction.innerHTML = JAjax.GetRequest("Ajax.php");
       };
       
       /**
        * Charge le projet complet
        * @returns 
        */
       TaskAction.OpenProjet = function(projetId)
       {
            var data = "Class=Task&Methode=OpenProjet&App=Task";
            data += "&projetId="+projetId;

            Dashboard.LoadControl("dvDesktop", data, "" , "div", "Task");   
       };
       
       /*
        * Rafraichit la liste des taches parentes.
        */
       TaskAction.RefreshParent = function(projetId)
       {
            var data = "Class=Task&Methode=RefreshParent&App=Task";
            data += "&projetId="+projetId;

            Dashboard.LoadControl("lstParent", data, "" , "div", "Task");   
       };
       
       /*
        * Charge les sous taches d'une taches mere
        */
       TaskAction.LoadSubTaskTask = function (TaskId)
       {
            var data = "Class=Task&Methode=LoadSubTaskTask&App=Task";
            data += "&taskId="+TaskId;

            Dashboard.LoadControl("lstChild", data, "" , "div", "Task");   
       };