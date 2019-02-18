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

