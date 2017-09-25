<div class='tools'>
    <span class="icon-plus-sign " onclick="EeMoocAction.ShowAddMooc();" title="Add" alt=""></span>
    <span class="icon-refresh " onclick="EeMoocAction.LoadPropose()" title="Rafraichir" alt=""></span>
</div>

<div class='mooc titleBlue slice' >
    <div><b>{{GetCode(Name)}}</b></div>
</div>

{{foreach}}
    <div class='mooc lineFonce'>
        <div>{{element->Name->Value}}</div>
        <div> 
            <span class="icon-gear" onclick="EeMoocAction.ShowAddMooc({{element->IdEntite}});" title="{{GetCode(EeMooc.EditMooc)}}" ></span>
            <span class="icon-edit"  onclick="EeMoocAction.EditMooc({{element->IdEntite}}, '{{element->Name->Value}}')" title="{{GetCode(EeMooc.OpenMooc)}}"   ></span>
        </div>
    </div>
{{/foreach}}


