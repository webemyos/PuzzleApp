var EntityGrid = function(){};

EntityGrid.Initialise = function(grid)
{
    setTimeout("EntityGrid.Init('"+grid+"')", 1000);
};

EntityGrid.Init = function(grid)
{
    EntityGrid.GridName = grid;
    
    //Init the Action of the column 
    var gd = document.getElementById(grid);
    var actionIcon = gd.getElementsByClassName("actionIcon");
    
    for(i = 0; i < actionIcon.length ; i++)
    {
        Dashboard.AddEvent(actionIcon[i], "click", EntityGrid.execute);
    }
    
    var pager = gd.getElementsByClassName("entityPager");
    
    for(i = 0; i < pager.length ; i++)
    {
        Dashboard.AddEvent(pager[i], "click", EntityGrid.loadPage);
    }
    
     var orders = gd.getElementsByClassName("order");
    
    for(i = 0; i < orders.length ; i++)
    {
        Dashboard.AddEvent(orders[i], "click", EntityGrid.sortPage);
    }
    
};

EntityGrid.execute = function(e)
{
    control = e.srcElement;
  
    action = control.dataset.action;
    idEntite = control.dataset.identite;
    params = control.dataset.params;
    
    eval(action + "("+ idEntite +", '"+params+"')");
          
};

EntityGrid.loadPage =function (e)
{
   control = e.srcElement;
   grid = control.parentNode.parentNode.parentNode.parentNode;
  
  if(grid != undefined)
  {
  
   app = grid.dataset.app.toString();
   action = grid.dataset.action.toString();
   order = grid.dataset.order;
   params = grid.dataset.params;

   //Lance une requete ajax pour charger le element suivant
   //La grid tout avoir tous les élements our souvri sur quoi requete
    grid.innerHTML = "Loading ...";
           var JAjax = new ajax();
               JAjax.data = "App=" + app +"&Methode=" + action;
               JAjax.data += "&Page=" + control.innerHTML;
               JAjax.data += "&Params=" + params;
         
        if(order != "")
        {
             JAjax.data += "&Sort=" + order;
        }
        
        grid.innerHTML = JAjax.GetRequest("Ajax.php");
    
    setTimeout("EntityGrid.Init('"+EntityGrid.GridName+"')", 1000);
    }
    
};

EntityGrid.sortPage =function (e)
{
   control = e.srcElement;
   grid = control.parentNode.parentNode.parentNode;
  
   if(grid != undefined)
  {
  
    app = grid.dataset.app.toString();
    action = grid.dataset.action.toString();
    params = grid.dataset.params;
   
    grid.dataset.order = control.innerHTML;

    //Lance une requete ajax pour charger le element suivant
    //La grid tout avoir tous les élements ou s'ouvrir sur quoi requete
     grid.innerHTML = "Loading ...";
            var JAjax = new ajax();
                JAjax.data = "App=" + app +"&Methode=" + action;
                JAjax.data += "&Sort=" + control.innerHTML;
                JAjax.data += "&Params=" + params;

            grid.innerHTML = JAjax.GetRequest("Ajax.php");

     setTimeout("EntityGrid.Init('"+ EntityGrid.GridName +"')", 1000);
  }

};

var UserActionColumn=new UserActionColumn();

function UserActionColumn()
{
	this.DoAction = function (UserAction, sender, id)
	{
		document.forms[sender].UserAction.value = UserAction;
		document.forms[sender].IdEntity.value = id;
	    document.forms[sender].submit();
	};
};