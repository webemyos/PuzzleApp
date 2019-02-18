<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddFicheProduct();" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{element->IdEntite}}, 'vTProduct_vtab_1', 'ProductBlock' , 'GetTabProductCategory')" title="{{GetCode(RefreshCategory)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(Description)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->Name->Value}}</div>
            <div>{{element->ShortDescription->Value}}</div>
            
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddFicheProduct({{element->IdEntite}})' title='{{GetCode(EditFiche)}}'  ></span>
            </div>
        </div>
    {{/foreach}}

