<div class="content-panel">
      {{GetControl(Button,AddApp,{LangValue=EeApp.AddApp,CssClass=btn btn-success,OnClick=EeAppAction.ShowAddApp()})}}
      {{GetControl(Button,UploadApp,{LangValue=EeApp.UploadApp,CssClass=btn btn-info,OnClick=EeAppAction.ShowUploadApp()})}}
      {{GetControl(Button,UploadLanguage,{LangValue=EeApp.UploadLanguage,CssClass=btn btn-info,OnClick=EeAppAction.ShowUploadLanguage()})}}


        <table class="table">
            <thead>
                <tr>
                  <th>{{GetCode(Category)}}</th>
                  <th>{{GetCode(Name)}}</th>
                  <th>{{GetCode(Description)}}</th>
                </tr>
            </thead>
                {{foreach}}
                    <tr>
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
