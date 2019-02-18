var PuzzleAppFrontEditModelController = function()
{
    this.template = "editModel.jtpl";
    this.nom =  {get get(){return this.nom},set set(val){this.nom = val; Dashboard.Observe(this);}};
    this.prenom =  {get get(){return this.prenom},set set(val){this.prenom = val; Dashboard.Observe(this);}};

    this.onInit = function()
    {
    };

    this.addEvent = function()
    {
        var app = this;

        Dashboard.AddEventById("btnSave", "click", function(){app.save()});
    };

    this.save = function()
    {
        alert("Alors tu veux enregistrer :" + this.nom.get + ":" + this.prenom.get);
    };

};