var PuzzleAppFrontHomeController = function()
{
    this.template = "home.jtpl";
    this.Views = new Array();

    this.name =  {get get(){return this.name},set set(val){this.name = val; Dashboard.Observe(this);}};
    this.prenom = {get get(){return this.prenom},set set(val){this.prenom = val; Dashboard.Observe(this);}};
    this.compteur = {get get(){return this.compteur},set set(val){this.compteur = val; Dashboard.Observe(this);}};
    this.entree = {get get(){return this.entree},set set(val){this.entree = val; Dashboard.Observe(this);}};
    this.email = {get get(){return this.email},set set(val){this.email = val; Dashboard.Observe(this);}};
    this.telephone = {get get(){return this.telephone},set set(val){this.telephone = val; Dashboard.Observe(this);}};
    this.products = Array();

    this.property = new Array();
    this.property["age"] = "13";

    articles = new Array();
    articles.push({nom:"test"});
    articles.push({nom:"toto"});
    
    this.property["article"] = articles;

    this.onInit = function()
    {
        this.name.set = "oliva";
        this.prenom.set = "jerome";
        this.compteur.set = 0;
        this.entree.set = "ton prenom";
        this.property["age"] = 25;
    };
    
    this.addEvent = function()
    {
        var App = this;

        Dashboard.AddEventById("btnTest", "click", function(){ App.hello()});
        Dashboard.AddEventById("btnChange", "click", function(){ App.change()});
        Dashboard.AddEventById("btnConteur", "click", function(){ App.incremente()});
        Dashboard.AddEventById("btnValid", "click", function(){ App.valid()});
       // Dashboard.AddEvent("deleIcon", "click", "delete");
    };

    this.hello = function(e)
    {
        Dashboard.setProperty("age", "13");
        this.name.set = "Christian";
        this.prenom.set = "slater";
    };

    this.change =function()
    {
        Dashboard.setProperty("age", "14");
        this.name.set = "Roger";
        this.prenom.set = "Carlitos";
    };

    this.incremente = function()
    {
        this.compteur.set =  this.compteur.get + 1 ;
        Dashboard.setProperty('age', this.property['age'] + 1); 
    };

    this.valid = function()
    {
        alert(this.email.get + "" + this.telephone.get + ":" + this.property["age"] );
    };
};