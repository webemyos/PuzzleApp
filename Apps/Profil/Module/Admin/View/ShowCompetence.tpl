
{{GetControl(Button,btnAddCompetence,{CssClass=btn btn-info,Value=AddCompetence,OnClick=ProfilAction.ShowAddCompetence()})}}


<table>
    <tr>
        <th>{{GetCode(Libelle)}}</th>
        <th>{{GetCode(Category)}}</th>
        <th></th>
    </tr>
    {{foreach Competence}}
        <tr>
            <td>{{element->Name->Value}}</td>
            <td>{{element->Category->Value->Name->Value}}</td>
            <td>
                {{GetControl(EditIcone, icEdit,{OnClick=ProfilAction.ShowAddCompetence({{element->IdEntite}})})}}
            </td>
        </tr>
    {{/foreach Competence}}
</table>