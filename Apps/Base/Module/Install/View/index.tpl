<h1>Programme d'installation</h1>

<div class='col-md-1' ></div>
<div class='row col-md-4'> 
{{GetForm(/Install)}}

    <div class="form-group"> 
        <label>Serveur</label>
        {{GetControl(TextBox,Serveur,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Base de donnée</label>
         {{GetControl(TextBox,DataBase,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Utilisateur</label>
        {{GetControl(TextBox,User,{Required=true})}}
    </div>
     <div class="form-group"> 
        <label>Pass</label>
         {{GetControl(PassWord,Password)}}
    </div>
    <div>
    {{GetControl(Submit,btnSubmit,{Value=Send})}}
    </div>
 
{{CloseForm()}}
