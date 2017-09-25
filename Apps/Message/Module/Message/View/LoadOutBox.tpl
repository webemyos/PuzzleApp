<div class="content-panel">
    <hr>
        <table class="table">
            <thead>
                <tr>
                  <th>{{GetCode(App)}}</th>
                  <th>{{GetCode(EeMessage.To)}}</th>
                  <th>{{GetCode(EeMessage.DateSended)}}</th>
                  <th>{{GetCode(EeMessage.Subject)}}</th>
                </tr>
            </thead>
            <tbody>
                {{foreach}}
                    <tr>
                        <td>{{element->GetImageApp()}}</td>
                        <td>{{element->GetDestinataire()}}</td>
                        <td>{{element->DateCreated->Value}}</td>
                        <td>{{element->Subjet->Value}}</td>
                        <td>
                            {{GetControl(EditIcone, Open, EeMessageAction.ShowDetailSend({{element->IdEntite}}))}} 
                        </td>
                        </td>
                    </tr>
                {{/foreach}}            
                </tbody>
            </table>
        </div>
</div>

