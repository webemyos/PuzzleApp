<h1>Programme d'installation</h1>

<div class='col-md-1' ></div>
<div class='row col-md-4'> 
{{GetForm(/Install)}}

    <div class="form-group"> 
        <label>Serveur de la base de données</label>
        {{GetControl(TextBox,Serveur,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Base de données</label>
         {{GetControl(TextBox,DataBase,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Utilisateur de la base de données</label>
        {{GetControl(TextBox,User,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Mot de passe de la base de données</label>
         {{GetControl(PassWord,Password)}}
    </div>
     <div class="form-group"> 
        <label>Adminstrateur du site</label>
        {{GetControl(EmailBox,Admin,{Required=true})}}
    </div>
    <div class="form-group"> 
        <label>Mot de passe</label>
         {{GetControl(PassWord,PassAdmin,{Required=true})}}
    </div>
    <div>
    {{GetControl(Submit,btnSubmit,{Value=Installer})}}
    </div>
 
{{CloseForm()}}
