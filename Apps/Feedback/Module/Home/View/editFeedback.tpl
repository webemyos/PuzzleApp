
<h4>{{element->Label->Value}}</h4>

<label>{{GetCode(User)}} : </label>
<span>
    {{element->User->Value->Name->Value}} 
    {{element->User->Value->FirstName->Value}}
</span>
<br/>
<textarea disabled>
    {{element->Description->Value}}
</textarea>