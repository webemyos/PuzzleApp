<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddUser();" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab('', 'vTInfo_vtab_1', 'ShopBlock' , 'GetTabUser')" title="{{GetCode(RefreshFournisseur)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(Product)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
           
            <div>{{element->User->Value->Email->Value}}</div>
            <div>{{element->Product->Value->NameProduct->Value}}</div>
        </div>
    {{/foreach}}

