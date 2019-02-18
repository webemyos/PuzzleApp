<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddUser();" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab('', 'vTInfo_vtab_1', 'ShopBlock' , 'GetTabUser')" title="{{GetCode(RefreshFournisseur)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(FirstName)}}</b></div>
        <div><b>{{GetCode(Email)}}</b></div>
        <div><b>{{GetCode(Group)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->Name->Value}}</div>
            <div>{{element->FirstName->Value}}</div>
            <div>{{element->Email->Value}}</div>
            <div>{{element->Groupe->Value->Name->Value}}</div>
            
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddUser({{element->IdEntite}})' title='{{GetCode(EditFournisseur)}}' ></span>
            </div>
        </div>
    {{/foreach}}

