<div class='tools'>
    <span class="icon-refresh " onclick="EeCommerceAction.RefreshCommande()" title="Rafraichir" alt=""></span>
</div>
    <div>
        <span class='col-md-4'>{{lstState}}</span>
        <span class='col-md-3'>{{tbNumero}}</span>
        <span class='col-md-2'>{{btnSearch}}</span>
    </div> 
    <div class='clear'></div>
    <div class='col-md-12' id='lstCommande'>
        <div class='commerce  titleBlue slice' >
            <div><b>{{GetCode(Numero)}}</b></div>
            <div><b>{{GetCode(DateCreated)}}</b></div>
            <div><b>{{GetCode(Total)}}</b></div>
        </div>

        {{foreach}}
            <div class='commerce lineFonce'>
                <div>{{element->Numero->Value}}</div>
                <div>{{element->DateCreated->Value}}</div>
                <div>{{element->GetTotal()}}</div>
                <div> 
                    <span  class='icon-edit '  onclick='EeCommerceAction.EditCommande({{element->IdEntite}})' title='{{GetCode(EditCommande)}}'  ></span>
                </div>
            </div>
        {{/foreach}}

    </div>