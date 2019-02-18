<div class='tools'>
    <span class="icon-plus-sign " onclick="EeCommerceAction.ShowAddCategory({{idCommerce}});" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{element->IdEntite}}, 'vTProduct_vtab_1', 'ProductBlock' , 'GetTabProductCategory')" title="{{GetCode(RefreshCategory)}}" alt=""></span>
</div>

    <div class='commerce fournisseur titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(Description)}}</b></div>
    </div>

    {{foreach}}
        <div class='commerce fournisseur lineFonce'>
            <div>{{element->Name->Value}}</div>
            <div>{{element->Description->Value}}</div>
            <div> 
                <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddCategory({{idCommerce}} , {{element->IdEntite}})' title='{{GetCode(EditCategory)}}'  ></span>
            </div>
        </div>
    {{/foreach}}

