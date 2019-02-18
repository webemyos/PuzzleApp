<div class='commerce titleBlue slice' >
    <div><b></b></div>
    <div><b>lbName</b></div>
    <div><b>lbTitre</b></div>
</div>

{{foreach}}
    <div class='commerce lineFonce'>
        <div>{{element->GetImage()}}</div>
        <div>{{element->Name->Value}}</div>
        <div>{{element->Title->Value}}</div>
        <div> 
            <span  class='icon-edit '  onclick='EeCommerceAction.LoadCommerce({{element->IdEntite}})' title='{{GetCode(LoadCommerce)}}' ></span>
        </div>
    </div>
{{/foreach}}


