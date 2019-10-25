<div class='row-fluid span12'>
    <h1>{{GetCode(Forum.Admin)}}</h1>
    
    <div>
        {{GetControl(Button,btnAddForum,{Value=Forum.AddForum,CssClass=btn btn-success,OnClick=ForumAction.ShowAddForum()})}}
    </div>
    
    {{foreach}}
        <div>
            {{element->Name->Value}}
            {{GetControl(EditIcone,Serveur,{OnClick=ForumAction.ShowAddForum({{element->IdEntite}})})}}
        </div>
    {{/foreach}}
</div>
