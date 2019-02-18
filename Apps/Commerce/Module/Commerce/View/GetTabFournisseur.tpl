<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddFournisseur({{idCommerce}});" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{idCommerce}}, 'vTProduct_vtab_0', 'ProductBlock' , 'GetTabFournisseur')" title="{{GetCode(RefreshFournisseur)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(Contact)}}</b></div>
        <div><b>{{GetCode(Email)}}</b></div>
        <div ><b>{{GetCode(NbProduct)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->Name->Value}}</div>
            <div>{{element->Contact->Value}}</div>
            <div>{{element->Email->Value}}</div>
            <div>{{element->GetNumberProduct()}}</div>
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddFournisseur({{idCommerce}} ,{{element->IdEntite}})' title='{{GetCode(EditFournisseur)}}' ></span>
            </div>
        </div>
    {{/foreach}}

