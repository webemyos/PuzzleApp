<div class='tools'>
    <span class="fa fa-plus" onclick="MoocAction.ShowAddMooc();" title="Add" alt=""></span>
    <span class="fa fa-refresh " onclick="MoocAction.LoadPropose()" title="Rafraichir" alt=""></span>
</div>

<div class='mooc titleBlue slice' >
    <div><b>{{GetCode(Name)}}</b></div>
</div>

{{foreach}}
    <div class='mooc lineFonce'>
        <div>{{element->Name->Value}}</div>
        <div> 
            <span class="fa fa-gear" onclick="MoocAction.ShowAddMooc({{element->IdEntite}});" title="{{GetCode(EeMooc.EditMooc)}}" ></span>
            <span class="fa fa-edit"  onclick="MoocAction.EditMooc({{element->IdEntite}}, '{{element->Name->Value}}')" title="{{GetCode(EeMooc.OpenMooc)}}"   ></span>
        </div>
    </div>
{{/foreach}}


