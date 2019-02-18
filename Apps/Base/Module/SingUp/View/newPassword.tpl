<h2>{{GetCode(Base.NewPassword)}}</h2>

{{if State == invalidToken}}

    {{GetCode(Base.InvalidToken)}}

{{/if State == invalidToken}}


{{if State == validToken}}

<form method='post' action='' >  

 <span class='error' > {{Error}}</span>

 <label>{{GetCode(NewPassword)}}</label>
    {{GetControl(Password,password,{Required=true, PlaceHolder=NewPassword})}} <br/>
 <label>{{GetCode(Verify)}}</label>
    {{GetControl(Password,verify,{Required=true, PlaceHolder=VerifyPassword})}} <br/>

    {{GetControl(Submit, btnLogin)}}<br/>
</form>

{{/if State == validToken}}

{{if State == updated}}

    {{GetCode(Base.passwordUpdated)}}
    
{{/if State == updated}}