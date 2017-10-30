<div class='tools'>
    <span class="fa fa-plus" onclick="MoocAction.ShowAddLesson({{moocId}});" title="{{GetCode(EeMooc.AddLesson)}}" ></span>
    <span class="fa fa-question" onclick="MoocAction.ShowAddQuiz({{moocId}});" title="{{GetCode(EeMooc.AddQuiz)}}" ></span>
    <span class="fa fa-refresh" onclick="MoocAction.RefreshLesson({{moocId}})" title="{{GetCode(Refresh)}}" ></span>
</div>

<div class='mooc titleBlue slice' >
    <div><b>{{GetCode(Name)}}</b></div>
</div>

{{foreach}}
    <div class='mooc lineFonce'>
        <div>{{element->Name->Value}} </div>
        <div> 
            <span class="fa fa-edit" onclick="MoocAction.ShowAddLesson({{moocId}}, {{element->IdEntite}},
                        '{{element->Name->Value}}');" title="{{GetCode("EeMooc.EditLesson")}}" ></span>
        </div>
    </div>
 {{/foreach}}

{{lstForm}}
