<div class="content-panel">
      {{GetControl(Button,AddApp,{Value=AddApp,CssClass=btn btn-success,OnClick=EeAppAction.ShowAddApp()})}}
      {{GetControl(Button,UploadApp,{Value=UploadApp,CssClass=btn btn-info,OnClick=EeAppAction.ShowUploadApp()})}}


        <table class="table">
            <thead>
                <tr>
                  <th></th>
                  <th>{{GetCode(Category)}}</th>
                  <th>{{GetCode(Name)}}</th>
                  <th>{{GetCode(Description)}}</th>
                </tr>
            </thead>
                {{foreach}}
                    <tr>
                        <td>{{element->GetImage()}}</td>
                         <td>{{element->Category->Value->Name->Value}}</td>
                        <td>{{element->Name->Value}}</td>
                        <td>{{element->Description->Value}}</td>
                        <td>
                            {{GetControl(EditIcone,Serveur,{OnClick=EeAppAction.ShowAddApp({{element->IdEntite}})})}}
                            {{GetControl(GroupIcone,Serveur,{OnClick=EeAppAction.ShowAdmin({{element->IdEntite}})})}}
                            {{GetControl(DeleteIcone,Serveur,{Id={{element->IdEntite}},OnClick=EeAppAction.RemoveApp(this)})}}
                        </td>
                    </tr>
                {{/foreach}}
                </tbody>
            </table>
        </div>
</div>
