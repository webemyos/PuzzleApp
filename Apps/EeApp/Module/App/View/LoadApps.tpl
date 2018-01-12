<div class="content-panel">
    <hr>
        <table class="table">
            <thead>
                <tr>
                  <th>{{GetCode(Category)}}</th>
                  <th>{{GetCode(Name)}}</th>
                  <th>{{GetCode(Description)}}</th>
                </tr>
            </thead>
            <tbody>
                {{foreach}}
                    <tr>
                        <td>{{element->Category->Value->Name->Value}}</td>
                        <td>{{element->Name->Value}}</td>
                        <td>{{element->Description->Value}}</td>
                        <td>
                            <input type='button' class='btn btn-success' onclick='EeAppAction.Add({{element->IdEntite}}, this)' value='{{GetCode(EeApp.Add)}}' />
                        </td>
                        </td>
                    </tr>
                {{/foreach}}            
                </tbody>
            </table>
        </div>
</div>

