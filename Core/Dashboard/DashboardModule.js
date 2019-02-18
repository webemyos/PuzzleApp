
/**
 * Charge et lance le module d'un app
 * @param {*} app
 * @param {*} module 
 */
Dashboard.LoadModule = function(app, module, container)
{
    Dashboard.IncludeJs(app, undefined,undefined,undefined, module);
    
    if(this.containerName == undefined || this.containerName == '') 
    {
        this.containerName = "content";
    }
    else
    {
        this.containerName = container;
    }
    
    className = app + module + "Controller";
    ViewName = app + module + "View";
    setTimeout("Dashboard.create("+className+")",200);
};

/**
 * Instate le module et lancé les fonctions de base
 * @param {*} className 
 */
Dashboard.create = function(className)
{
    var module = new className();
    
    if(module.onInit != undefined)
    {
        module.onInit();
    }
    if(module.onRender != undefined)
    {
        module.onRender();
    }

    Dashboard.render(module, className + "View");
    Dashboard.bindInput(module);
    
    if(module.addEvent != undefined)
    {
        module.addEvent();
    }
    if(module.onDestroy != undefined)
    {
        module.onDestroy();
    }
};

/**
 * Effectue le Render
 * @param {*} module 
 */
Dashboard.render = function(module, className)
{
    view = eval(ViewName);

    for(i = 0; i< view.length; i++)
    {
        if(view[i][0] == module.template)
        {
            content = view [i][1];
        }
    }

    content = Dashboard.replaceProperty(module, content);
    
    if(this.containerName == undefined || this.containerName == '')
    {
        var dvContent = document.getElementsByTagName("content");
    }
    else
    {
        var dvContent = document.getElementsByTagName(this.containerName);
    }

    dvContent[0].innerHTML = content;
};

/**
 * Remplace les propriété connues
 * @param {*} module 
 * @param {*} content 
 */
Dashboard.replaceProperty = function(module, content)
{
    for (var property in module)
    {
        if(typeof(module[property]) == "object")
        {
            if(typeof(module[property]).get == "object")
            {
                content = Dashboard.replaceObject(module[property], module[property].get, content);
            }
            else
            {
                content = content.replace("{{" + property + "}}", "<"+property+">" +  ( module[property].get != undefined ? module[property].get :'' ) + "</"+property+">");
            }
        }
    }

    console.log(module.property);

    for (var property in module.property)
    {
            console.log( property + ":" + module.property[property]);

            console.log( typeof(module.property[property]));

           if(typeof(module.property[property]) == "object")
            {
                content = Dashboard.replaceObject(module.property[property], module.property[property], content);
            }
            else
            {
                content = content.replace("{{" + property + "}}", "<"+property+">" +  ( module.property[property] != undefined ? module.property[property] :'' ) + "</"+property+">");
            }
       
    }


    return content;
};

/**
 * Remplace une collection d'objet
 */
Dashboard.replaceObject = function(module, property,  content)
{
    for (var vars in module)
    {
        if(vars != "get" && vars != "set")
        {
            propertyName = vars;
        }
    }
    var start = content.indexOf("{{foreach "+propertyName+"}}");
    var end = content.indexOf("{{/foreach "+propertyName+"}}");

    line = content.substring(start, end).replace("{{foreach "+propertyName+"}}", "");

    //AJout de la ligne pour pouvoir la retrouvé plus tard
    Dashboard[propertyName] = line;

    lines = "";

    for (var prop in property)
    {
       newLine = line;

       for(var val in property[prop])
       {
           console.log(val + ":" + property[prop][val]);
         newLine = newLine.replace("{{entity."+val+"}}", property[prop][val]);
       }
       lines += newLine;
    }

    return content.replace("{{foreach "+propertyName+"}}", "<table id='"+ propertyName + "'>" +  lines)
                  .replace("{{/foreach "+propertyName+"}}", "</table>")
                  .replace(line, ""); 

};

/**
 * Remplit les input avec les propriété
 * et gére les events
 * @param {*} module 
 * @param {*} content 
 */
Dashboard.bindInput = function(module, content)
{
    //TODO COMPRENDRE POURQUOI ON PERD le CONTAINER
    if(this.containerName == undefined || this.containerName == '')
    {
        this.containerName = "content";
    }
    
    var content = document.getElementsByTagName(this.containerName);
    var input = content[0].getElementsByTagName("input");

    for(i=0; i < input.length; i++)
    {
        if(input[i].dataset.bind != "")
        {
            for (var property in module)
            {
                if(property == input[i].dataset.bind )
                {
                    if(module[property].get != undefined)
                    {
                        input[i].value = module[property].get;
                    }

                    //ON sauvegarde le module courant
                    Dashboard.module = module;
                    Dashboard.AddEvent(input[i], "blur", Dashboard.replaceValue );
                }
            }

            for (var property in module.property)
            {
                if(property == input[i].dataset.bind )
                {
                    input[i].value = module.property[property];
                    //ON sauvegarde le module courant
                    Dashboard.module = module;
                    Dashboard.AddEvent(input[i], "blur", Dashboard.replaceValue );
                }
            }
        }
    }
};

/*
* Initialise la variable Js avec La nouvelle valeur de l'input
*/
Dashboard.replaceValue = function(e)
{
    //Il faut retrouver la bonne propriété
    for (var property in Dashboard.module)
    {
        if(property == e.srcElement.dataset.bind )
        {
            Dashboard.module[property].set = this.value;
        }
    }

    for (var property in Dashboard.module.property)
    {
        if(property == e.srcElement.dataset.bind )
        {
            Dashboard.module.property[property] = this.value;
            Dashboard.setProperty(property, this.value);
        }
    }
};

/**
 * Modifie le content lorsque l'on set une property
 * @param {*} property 
 */
Dashboard.Observe = function(property)
{
    for (var val in property)
    {
        if(val != "get" && val != "set")
        {
            var element = document.getElementsByTagName(val);
            if(element.length > 0)
            {
                element[0].innerHTML = property.get;
            }
            else
            {
                var grid = document.getElementById(val);
                if(grid != undefined) 
                {
                    var lines = "";

                    //TROUVER LE BON ELEMENT
                    var line = Dashboard[val] ;

                    console.log(line);
                    for (var prop in property)
                    {
                        if(prop != "get"  )
                        {
                            for(var val in property[prop])
                            {
                                var newLine = line;

                                for(data in property[prop][val])
                                {
                                    newLine = newLine.replace("{{entity."+data+"}}", property[prop][val][data]);
                                }
                                lines += newLine;
                            }
                        }
                    }
                    grid.innerHTML = lines;
                    console.log(lines);
                }
            }
        }
    }
};

/**
 * Set une propriété
 */
Dashboard.setProperty=function(property, value)
{
    var element = document.getElementsByTagName(property);
    if(element.length > 0)
    {
        element[0].innerHTML = value;
    }
};

