var PuzzleAppFrontModelController = function()
{
    this.template = "model.jtpl";
    this.products = {get get(){return this.products},set set(val){this.products = val; Dashboard.Observe(this);}};

    this.onInit = function()
    {
        var products = new Array();
        data = "Methode=GetMember";
        data += "&App=PuzzleAppFront";
       // data += "&Class=PuzzleAppFront";
        
        product = new Array();
        product.push({"Nom":"oliva","Prenom":"jerome"});
       
        this.products.set = JSON.parse(JSON.stringify(product));

        
        Request.Post("../Ajax.php",data).then(data=>{
           
            this.products.set = JSON.parse(data);

            });
    };

    this.addEvent = function()
    {
         //Gestion Des Events
        var App = this;
        Dashboard.AddEventById("btnAdd", "click", function(){App.showAddModel()});
    };

    this.showAddModel = function(e)
    {
        Dashboard.OpenPopUp({App:"PuzzleAppFront",
                             Module : "EditModel",
                             ControllerType : "Front",
                             Title : "AddModel"
                            }  );
    };
};