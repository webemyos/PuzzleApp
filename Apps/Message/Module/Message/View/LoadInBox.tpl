<div class="content-panel">
    <hr>
        <table class="table">
            <thead>
                <tr>
                  <th>{{GetCode(EeMessage.Sender)}}</th>
                  <th>{{GetCode(App)}}</th>
                  <th>{{GetCode(EeMessage.DateSended)}}</th>
                  <th>{{GetCode(EeMessage.Subject)}}</th>
                </tr>
            </thead>
            <tbody>
                {{foreach}}
                    <tr>
                        <td>{{element->Message->Value->GetPseudo()}}</td>
                        <td>{{element->Message->Value->GetImageApp()}}</td>
                        <td>{{element->Message->Value->DateCreated->Value}}</td>
                        <td>{{element->Message->Value->Subjet->Value}}</td>
                        <td>
                            {{GetControl(EditIcone,Open,{OnClick=MessageAction.ShowDetail({{element->IdEntite}})})}} 
                        </td>
                        </td>
                    </tr>
                {{/foreach}}            
                </tbody>
            </table>
        </div>
</div>

