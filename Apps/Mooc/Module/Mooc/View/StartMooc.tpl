<div class='row'>
    <div class='col-md-12'>
        <h4>{{GetCode(EeMooc.PresentationMooc)}} : {{MoocName}}</h4>
        <p>{{MoocDescription}}</p>
    </div>
  
    <div class='col-md-12'>
        <a href='{{lkNewWindow}}' target='_blank' class='btn btn-success'>{{GetCode(OpenInNewWindow)}}</a>
    </div>
    
    <div class='col-md-3'>
        <div class='global-bloc-simple' >
            <h3>{{GetCode(EeMooc.Summary)}}</h3>
            <ul style='text-align:left'>
                {{foreach}}
                <li title='{{element->Name->Value}}' >
                    <a href='#' onclick="EeMoocAction.LoadLesson({{element->IdEntite}});" > {{element->Name->Value}}  </a>
                </li>

                {{/foreach}}
            {{lstForm}}
            </ul>
        </div>
        
    </div>
    <div class='col-md-8' id='dvLesson'>
       {{lessonOne}}
    </div>
    
    
</div>