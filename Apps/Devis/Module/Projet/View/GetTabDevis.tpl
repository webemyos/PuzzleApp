<div class='tools'>
    <span class="fa fa-plus " onclick="DevisAction.ShowAddDevis({{projetId}});" title="Add" alt=""></span>
    <span class="fa fa-refresh " onclick="DevisAction.RefreshTabDevis({{projetId}})" title="Rafraichir" alt=""></span>
</div>

    <div class='devis  titleBlue slice' >
        <div><b>lbNumber</b></div>
    </div>
    {{foreach}}
        <div class='devis lineFonce'>
            <div>{{element->Number->Value}}</div>
            <div> 
                <span  class='fa fa-edit'  onclick='DevisAction.ShowAddDevis({{projetId}} ,{{element->IdEntite}})' title='lbTitleIconeEdit' alt ='lbTitleIconeEdit'  ></span>
                <span>{{element->GetDocument()}}</span>
            </div>
        </div>
    {{/foreach}}
    
    

