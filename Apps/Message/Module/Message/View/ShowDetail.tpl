<div class="content-panel">
    <h4>{{GetCode(Subjet)}} : {{element->Message->Value->Subjet->Value}}</h4>
    <p>{{GetCode(Sender)}} : {{element->GetSender()}}</p>
    
    <p><textarea disabled="disabled">{{element->Message->Value->Message->Value}}</textarea></p>
    
    <div>
        {{btnReponse}}
    </div>
    
    <div id='dvReponse' style='display:none'>
        {{tbReponse}}
        <br/>
        {{btnSend}}
    </div>
</div>

