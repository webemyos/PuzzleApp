<div class='content-panel' >
    <div id='dvCompetenceUser' class='row'>
       {{foreach Category}}
            <div class='categorie col-md-4'>
            <div class='titleBlue'>{{element->Name->Value}}</div>
               {{element->GetHtmlCompetenceByUser()}}
               
            </div>
        {{/foreach Category}}
    </div>
    
    <div>
        {{GetControl(Button,btnSave,{Value=save,CssClass=btn btn-success,OnClick=ProfilAction.SaveCompetence()})}}
    </div>
</div>