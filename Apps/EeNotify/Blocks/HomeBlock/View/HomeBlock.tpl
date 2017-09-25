<div class="content-panel">
    <hr>
        <table class="table">
            <thead>
                <tr>
                  <th>{{GetCode(Application)}}</th>
                  <th>{{GetCode(Membre)}}</th>
                  <th>{{GetCode(Date)}}</th>
                  <th>{{GetCode(Message)}}</th>
                </tr>
            </thead>
            <tbody>
                {{foreach}}
                    <tr>
                        <td>{{element->AppName->Value}}</td>
                         <td>{{element->User->Value->GetPseudo()}}</td>
                        <td>{{element->DateCreate->Value}}</td>
                        <td>{{GetCode({{element->Code->Value}})}}</td>
                        <td>
                            <input type='button' class='btn btn-primary' value="{{GetCode(EeNotify.Start)}}" onclick="Eemmys.StartApp('', '{{element->AppName->Value}}', '')" />
                        </td>    
                    </tr>
                {{/foreach}}            
                </tbody>
            </table>
        </div>
</div>
