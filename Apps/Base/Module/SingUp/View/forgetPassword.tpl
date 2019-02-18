<h2>{{GetCode(Base.ForgetPassword)}}</h2>


{{if Success == false}}

<form method='post' action='' >  
 <label>{{GetCode(Email)}}</label>
    {{GetControl(EmailBox,email,{Required=true, PlaceHolder=VotreEmail})}} <br/>


        {{GetControl(Submit, btnLogin)}}<br/>

</form>

{{/if Success == false}}

{{if Success == true}}

    {{Message}}
    
{{/if Success == true}}