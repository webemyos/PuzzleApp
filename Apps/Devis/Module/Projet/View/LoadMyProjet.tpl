<div class='devis titleBlue slice' >
    <div><b>lbName</b></div>
</div>

{{foreach}}
    <div class='devis lineFonce'>
        <div>{{element->Libelle->Value}}</div>
        <div> 
            <span  class='fa fa-edit'  onclick='DevisAction.LoadProjet({{element->IdEntite}})' title='lbTitleIconeEdit' alt ='lbTitleIconeEdit'  ></span>
        </div>
    </div>
{{/foreach}}


