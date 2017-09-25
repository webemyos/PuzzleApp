{{foreach}}

<div class='mooc'>

    {{element->Mooc->Value->Name->Value}}
    
    <p>
        {{element->Mooc->Value->Description->Value}}
    </p>

    <div class='alignRight'>
        <button class='btn btn-primary' onClick='EeMoocAction.StartMooc({{element->MoocId->Value}})'>{{GetCode(EeMooc.StartMooc)}}</button>
        
    </div>
</div>
    
{{/foreach}}