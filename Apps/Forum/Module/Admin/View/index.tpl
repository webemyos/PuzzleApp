<div class='row-fluid span12'>
    <h1>{{GetCode(Forum.Admin)}}</h1>
    
    <div>
        {{GetControl(Button,btnAddForum,{Value=Send,CssClass=btn btn-success,OnClick=ForumAction.ShowAddForum()})}}
    </div>
    
    {{foreach}}
        {{element->Name->Value}}
    {{/foreach}}
</div>
