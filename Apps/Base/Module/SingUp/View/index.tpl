<section>
<h1>{{GetCode(Connexion)}}</h1>

{{if Success == true}}

    {{GetCode(Base.CompteCreated)}}
    
{{/if Success == true}}

{{if Success == false}}

<form method='post' action='' >  
    {{error}} 
    
    <label>{{GetCode(Login)}}</label>
    {{GetControl(EmailBox,login,{Required=true, PlaceHolder=VotreEmail})}} <br/>
   
    <label>{{GetCode(Password)}}</label>
    {{GetControl(PassWord,password,{Required=true, PlaceHolder=VotrePass})}} <br/>
    
    <label>{{GetCode(Verif)}}</label>
    {{GetControl(PassWord,verif,{Required=true, PlaceHolder=Verification})}} <br/>
    
    {{GetWidget(Captcha)}}
    
    {{GetControl(Submit, btnLogin)}}<br/>

</form>
{{/if Success == false}}

</section>