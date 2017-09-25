<div class='tools'>
    <span class="icon-plus-sign " onclick="EeMoocAction.ShowAddLesson({{moocId}});" title="{{GetCode(EeMooc.AddLesson)}}" ></span>
    <span class="icon-question " onclick="EeMoocAction.ShowAddQuiz({{moocId}});" title="{{GetCode(EeMooc.AddQuiz)}}" ></span>
    <span class="icon-refresh " onclick="EeMoocAction.RefreshLesson({{moocId}})" title="{{GetCode(Refresh)}}" ></span>
</div>

<div class='mooc titleBlue slice' >
    <div><b>{{GetCode(Name)}}</b></div>
</div>

{{foreach}}
    <div class='mooc lineFonce'>
        <div>{{element->Name->Value}} </div>
        <div> 
            <span class="icon-edit" onclick="EeMoocAction.ShowAddLesson({{moocId}}, {{element->IdEntite}},
                        '{{element->Name->Value}}');" title="{{GetCode("EeMooc.EditLesson")}}" ></span>
        </div>
    </div>
 {{/foreach}}

{{lstForm}}
