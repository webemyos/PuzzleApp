<div class="heading-container heading-resize heading-no-button">
    <div class="heading-background heading-parallax bg-2">
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                        <br><br><br><br><br><br><br>
                        </div>
                </div>
            </div>
        </div>
</div>
<div class='row'>
    <div class='col-md-2'></div>
    <div class='col-md-10'>
        <h3 class='borderbottom'><i class='fa fa-2x fa-list'>&nbsp</i>{{GetCode(MyCommande)}}</h3>
    </div>
    <div class='col-md-2'></div>
    <div id='dvUser' class='col-md-8'>
        {{foreach}}
            <div class='borderbottom'>
                <h4>{{GetCode(Commande)}} : {{element->Numero->Value}}</h4>
                <span class='col-md-2'>{{GetCode(dateCommande)}}</span><span class='col-md-2'>{{element->DateCreated->Value}}</span> 
                <span class='col-md-2'>{{GetCode(state)}}</span><span class='col-md-2'>{{element->GetState()}}</span> 
                <span class='col-md-1'>{{GetCode(total)}}</span><span class='col-md-2'>{{element->GetTotal()}}</span> 
                <span class='col-md-1'>
                    <a href='#' class='btn btn-success-outline' title="{{GetCode(Detail)}}" 
                                            onclick='VenteGivreeAction.ShowProducts({{element->IdEntite}})' >
                        {{GetCode(Detail)}}</a>
                </span>
            
            <div id='dvDetail{{element->IdEntite}}' style='display:none' >

            </div>
            <div class='clear'></div>
            </div>
        {{/foreach}}
    </div>

</div>
    

