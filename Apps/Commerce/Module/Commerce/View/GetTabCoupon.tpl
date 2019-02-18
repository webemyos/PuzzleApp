<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddCoupon();" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab('', 'vTInfo_vtab_2', 'ShopBlock' , 'GetTabCoupon')" title="{{GetCode(RefreshCoupon)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Code)}}</b></div>
        <div><b>{{GetCode(Libelle)}}</b></div>
        <div><b>{{GetCode(Type)}}</b></div>
        <div><b>{{GetCode(Reduction)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->Code->Value}}</div>
            <div>{{element->Libelle->Value}}</div>
            <div>{{element->Type->Value}}</div>
            <div>{{element->Reduction->Value}}</div>
            
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddCoupon({{element->IdEntite}})' title='{{GetCode(EditFournisseur)}}' ></span>
            </div>
        </div>
    {{/foreach}}

