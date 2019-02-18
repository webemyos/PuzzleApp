<div class='tools'>
    <span class="icon-plus-sign " onclick="EeDevisAction.ShowAddModele({{projetId}});" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeDevisAction.RefreshTabModele({{projetId}})" title="Rafraichir" alt=""></span>
</div>

    <div class='devis  titleBlue slice' >
        <div><b>lbNumber</b></div>
    </div>

    {{foreach}}
        <div class='devis lineFonce'>
            <div>{{element->Number->Value}}</div>
            <div> 
                <span  class='icon-edit '  onclick='DevisAction.ShowAddModele({{projetId}} ,{{element->IdEntite}})' title='lbTitleIconeEdit' alt ='lbTitleIconeEdit'  ></span>
            </div>
        </div>
    {{/foreach}}

