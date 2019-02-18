<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddMarque({{idCommerce}});" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{idCommerce}}, 'vTProduct_vtab_3', 'ProductBlock' , 'GetTabMarque')" title="{{GetCode(RefreshMarque)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div></div>
        <div><b>{{GetCode(Name)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->GetImage()}}</div>
            <div>{{element->Name->Value}}</div>
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddMarque({{idCommerce}} ,{{element->IdEntite}})' title='{{GetCode(EditMarque)}}' ></span>
            </div>
        </div>
    {{/foreach}}

