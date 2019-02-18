<div id='lstProduct'>

<div class='tools'>
    <span class="icon-plus-sign" onclick="EeCommerceAction.ShowAddProduct({{idCommerce}});" title="Add" alt=""></span>
    <span class="icon-file" onclick="EeCommerceAction.ShowImport({{idCommerce}});" title="{{GetCode(ImportProduct)}}" alt=""></span>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshTab({{element->IdEntite}}, 'vTProduct_vtab_2', 'ProductBlock' , 'GetTabProduct')" title="{{GetCode(RefreshProduct)}}" alt=""></span>
</div>
    <div>
        {{lstFournisseur}}
    </div>
    
    <div class='commerce product titleBlue slice' >
        <div><b>{{GetCode(Name)}}</b></div>
        <div><b>{{GetCode(Ref)}}</b></div>
        <div><b>{{GetCode(Fournisseur)}}</b></div>
        
        <div><b>{{GetCode(Marque)}}</b></div>
        
        <div><b>{{GetCode(PriceBuy)}}</b></div>
        <div><b>{{GetCode(PriceVenteMini)}}</b></div>
        <div><b>{{GetCode(PriceVenteMaxi)}}</b></div>
        <div><b>{{GetCode(PriceDown)}}</b></div>
        <div><b>{{GetCode(Quantity)}}</b></div>
        <div><b>{{GetCode(Actif)}}</b></div>
        <div><b>{{GetCode(Image)}}</b></div>
        
    </div>


        {{foreach}}
            <div class='commerce product lineFonce'>
                <div>{{element->NameProduct->Value}}</div>
                <div>{{element->RefProduct->Value}}</div>
                <div>{{element->GetFournisseur()}}</div>
               
                <div>{{element->GetMarque()}}</div>
                
                <div>{{element->PriceBuy->Value}}</div>
                <div>{{element->PriceVenteMini->Value}}</div>
                <div>{{element->PriceVenteMaxi->Value}}</div>
                <div>{{element->PriceDown->Value}}</div>
                <div>{{element->Quantity->Value}}</div>
                <div>{{element->Actif->Value}}</div>
                 <div> 
                    <span  class='icon-edit '  onclick='EeCommerceAction.ShowAddProduct({{idCommerce}} ,{{element->IdEntite}})' title='{{GetCode(EditProduct)}}'   ></span>
                </div>
                 <div>{{element->GetImage()}}</div>
               
            </div>
        {{/foreach}}
    </div>
