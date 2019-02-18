<h3>{{GetCode(commande)}} {{element->Numero->Value}}</h3>
<h4>{{GetCode(Product)}}</h4>
<div class='row'>
    <div class='col-md-5'>
        {{TProducts}}
    </div>
    <div class=''>
        <h4>{{GetCode(Virement)}}</h4>
        {{TVirements}}
    </div>
    <div class='col-md-5'>
    <h4>{{GetCode(Suivi)}}</h4>
        <div>
            <span class='col-md-3'>{{GetCode(DateCreated)}}</span>
            <span class='col-md-3'>{{element->DateCreated->Value}}</span>

            <span class='col-md-3'>{{GetCode(DateValidation)}}</span>
            <span class='col-md-3'>{{element->DateValidation->Value}}</span>
        </div>
    </div>
</div>   
<h4>{{GetCode(Document)}}</h4>
<div>
    <div class='col-md-5'>
        <h5>{{GetCode(Facture)}}</h5>
            <ul>
            {{lstFacture}}
            </ul>
    </div>
    <div class='col-md-5'>
        <h5>{{GetCode(BonCommande)}}</h5>
            <ul>
            {{lstBonCommande}}
            </ul>
    </div>

</div>