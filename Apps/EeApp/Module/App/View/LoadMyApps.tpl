<div class="content-panel">
        <table class="table">
            <thead>
                <tr>
                  <th></th>
                  <th>{{GetCode(Name)}}</th>
                  <th>{{GetCode(Description)}}</th>
                </tr>
            </thead>
            <tbody>
                {{foreach}}
                    <tr>
                        <td>{{element->App->Value->GetImage()}}</td>
                        <td>{{element->App->Value->Name->Value}}</td>
                        <td>{{element->App->Value->Description->Value}}</td>
                        <td><input type='button' class='btn btn-primary' onclick='EeAppAction.Remove({{element->IdEntite}}, this)' value='{{GetCode(EeApp.Remove)}}' /></td>
                    </tr>
                {{/foreach}}           
                </tbody>
            </table>
        </div>
</div>