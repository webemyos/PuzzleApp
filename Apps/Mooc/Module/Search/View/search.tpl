{{foreach}}

<div class='mooc'>

    {{element->Name->Value}}
    
    <p>
        {{element->Description->Value}}
    </p>

    <div class='alignRight'>
        <button class='btn btn-primary' onClick='EeMoocAction.StartMooc({{element->IdEntite}})'>{{GetCode(EeMooc.StartMooc)}}</button>
        
    </div>
</div>
    
{{/foreach}}