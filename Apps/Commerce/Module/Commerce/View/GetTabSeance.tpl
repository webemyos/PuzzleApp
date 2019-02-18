<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddSeanceVente({{idCommerce}});" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{idCommerce}}, 'vTVente_vtab_0', 'SaleBlock' , 'GetTabSeance')" title="Rafraichir" alt=""></span>
</div>

    <div class='commerce  titleBlue slice' >
        <div><b>{{GetCode(Libelle)}}</b></div>
        <div><b>{{GetCode(DateStart)}}</b></div>
        <div><b>{{GetCode(DateEnd)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce lineFonce'>
            <div>{{element->Libelle->Value}}</div>
            <div>{{element->DateStart->Value}}</div>
            <div>{{element->DateEnd->Value}}</div>
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddSeanceVente({{idCommerce}} ,{{element->IdEntite}})' title='{{GetCode(EditSeance)}}'  ></span>
           </div>
        </div>
    {{/foreach}}

