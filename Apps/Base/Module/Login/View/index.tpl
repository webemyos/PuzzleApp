<section>
<h1>{{GetCode(Connexion)}}</h1>

<form method='post' action='Connect' >  
    {{error}} <br/>
    <label>{{GetCode(Login)}}</label>
    {{GetControl(EmailBox,login,{Required=true, PlaceHolder=VotreEmail})}} <br/>
    <label>{{GetCode(Password)}}</label>
    {{GetControl(Password,password,{Required=true, PlaceHolder=VotreEmail})}}<br/>

    <label></label>{{GetControl(Submit, btnLogin)}}<br/>

</form>

<div style='text-align:right'>
    <a href='{{GetPath(/ForgetPassword)}}' >{{GetCode("Base.ForgetPassword")}}</a>
    <a href='{{GetPath(/Singup)}}' >{{GetCode("Base.Signup")}}</a>
</div>

</section>